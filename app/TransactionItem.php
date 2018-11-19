<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TransactionItem extends Model
{
    protected $fillable = [
      'transaction_id',
      'menu_item_id',
      'comments',
      'name',
      'price',
      'discount',
    ];

    public function extras()
    {
      return $this->hasMany('App\TransactionExtra', 'transaction_item_id');
    }

    public function transaction()
    {
      return $this->belongsTo('App\Transaction');
    }

    public function item()
    {
      return $this->belongsTo('App\MenuItem', 'menu_item_id');
    }
}
