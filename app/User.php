<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laratrust\Traits\LaratrustUserTrait;
use Laratrust;
use Carbon\Carbon;
use NotificationChannels\WebPush\HasPushSubscriptions;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'email_token', 'business_id', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // RELATIONS
    public function business()
    {
      return $this->belongsTo('App\Business');
    }

    public function transactions()
    {
      return $this->hasMany('App\Transaction', 'user_id');
    }

    public function transaction_items()
    {
      return $this->hasManyThrough('App\TransactionItem', 'App\Transaction')->whereHas('transaction', function ($q) {
        $q->where('status', 'accepted');
      });
    }

    public function carts()
    {
      return $this->hasMany('App\Cart');
    }

    public function reviews()
    {
      return $this->hasMany('App\Review');
    }

    // SCOPES
    public function scopeSearch($query, $column, $value)
    {
      return $query->where($column, 'LIKE', "%$value%");
    }

    public function scopeDevelopers($query)
    {
      return $query->where('developer', 1);
    }

    // ATTRIBUTES
    public function getEditableAttribute()
    {
        return !$this->developer;
    }

    public function getDeleteableAttribute()
    {
        return $this->editable;
    }

    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    // PERMISSION CHECKS
    public function canEditBusiness($business)
    {
      if(!$business)
        return false;

      return $this->can('businesses.edit') && ($business->owns($this) || $this->hasRole(['Admin', 'Developer']));
    }

    public function canDeleteBusiness($business)
    {
      if(!$business)
        return false;

      return $this->can('businesses.delete') && ($business->owns($this) || $this->hasRole(['Admin', 'Developer']));
    }

    public function canCreateBusiness()
    {
      return $this->can('businesses.create');
    }

    public function canReviewItem($item)
    {
      if ($this->developer) {
        return true;
      }
      else {
        $id = ctype_digit($item) ? $item : $item->id;
        return $this->can('reviews.create') && $this->transaction_items->pluck('menu_item_id')->contains($id);
      }
    }

    // UTILITIES
    public function canMakeTransaction()
    {
      $transaction = $this->transactions()->orderByDesc('created_at')->first();

      if($transaction == null)
        return true;

      if($transaction->created_at->addMinutes(2)->lte(Carbon::now()))
        return true;

      return false;
    }

}
