<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Laratrust\Traits\LaratrustUserTrait;
use App\OperatingHour;
use App\Menu;
use Auth;
use Storage;
use DB;
use Image;
use Log;
use App\MenuExtra;
use App\Tag;
use App\TransactionItem;

class Business extends Model
{
    use LaratrustUserTrait;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    public $timestamps = false;
    protected $fillable = [
      'name',
      'phone',
      'email',
      'website',
      'addressLine1',
      'addressLine2',
      'locality',
      'postcode',
      'latitude',
      'longitude',
      'supports_payment',
      'image_path',
    ];

    public function transactions()
    {
      return $this->hasMany('App\Transaction');
    }

    public function menuitems()
    {
      return $this->hasManyThrough('App\MenuItem', 'App\Menu');
    }

    public function getShortreviewsAttribute()
    {
      if (count($this->menuitemreviews) > 0) {
        return number_format(($this->menuitemreviews->sum('rating') / count($this->menuitemreviews)), 1) . '/100';
      }
      return 'No reviews yet';
    }

    public function menuitemreviews()
    {
      return $this->hasManyDeep('App\Review', ['App\Menu', 'App\MenuItem']);
    }

    public function menus()
    {
      return $this->hasMany('App\Menu')->orderBy('main', 'desc');
    }

    public function main_menu()
    {
      return $this->hasOne('App\Menu')->where('main', 1);
    }

    public function menuswithitems()
    {
      return $this->hasMany('App\Menu')->with('menuitems')->orderBy('main', 'desc');
    }

    //the users who own this business
    public function users()
    {
      return $this->hasMany('App\User');
    }

    //carts of this business
    public function carts()
    {
      return $this->hasMany('App\Cart');
    }

    public function operatinghours()
    {
      return $this->morphMany('App\OperatingHour', 'entry');
    }

    public function tags()
    {
      return $this->belongsToMany('App\Tag');
    }

    public function getCurrentOpeningHoursAttribute()
    {
        $currentDow = (Carbon::now()->format('N')) - 1;
        $currentOh = OperatingHour::where('entry_type', 'App\Business')->where('entry_id', $this->id)->where('day', $currentDow)->first();
        try {
          return 'Closes at ' . date('g:i a', strtotime($currentOh->closing_time));
        }
        catch (\Exception $e) {
          Log::error('Error: no Operating Hours for business' . $this->id . 'in search results.');
          return 'Currently closed';
        }
    }

    // SCOPES
    public function scopeSearch($query, $column, $value)
    {

      $tags = explode(" ", $value);

      return $query
        ->whereHas('tags', function ($q) use ($tags) {
          $q->where(function ($q) use ($tags) {
            foreach ($tags as $tag) {
              $q->orWhere('tags.name', 'like', "%$tag%");
            }
          });
        })
        ->orWhere($column, 'LIKE', "%$value%");

    }

    public function scopeInRadius($query, $lat, $long, int $radius = 10)
    {
      if (empty($lat) || empty($long)) {
        return $query;
      }

      $radius = self::geoRadius($lat, $long, $radius);

      return $query
        ->whereBetween('latitude', [$radius['latMIN'], $radius['latMAX']])
        ->whereBetween('longitude', [$radius['lonMIN'], $radius['lonMAX']]);
    }


    public static function geoRadius($lat, $lng, $rad, $kilometers=true) {
      $radius = ($kilometers) ? ($rad * 0.621371192) : $rad;

      (float)$dpmLAT = 1 / 69.1703234283616;

      // Latitude calculation
      (float)$usrRLAT = $dpmLAT * $radius;
      (float)$latMIN = $lat - $usrRLAT;
      (float)$latMAX = $lat + $usrRLAT;

      // Longitude calculation
      (float)$mpdLON = 69.1703234283616 * cos($lat * (pi()/180));
      (float)$dpmLON = 1 / $mpdLON; // degrees per mile longintude
      $usrRLON = $dpmLON * $radius;

      $lonMIN = $lng - $usrRLON;
      $lonMAX = $lng + $usrRLON;

      return array("lonMIN" => $lonMIN, "lonMAX" => $lonMAX, "latMIN" => $latMIN, "latMAX" => $latMAX);
    }

    public function scopeOpen($query)
    {
      // Check if in debug mode
      if (config('app.debug')) {
        return $query;
      }
      else {
        return $query->whereHas('operatinghours', function ($q){
          $q->whereRaw('operating_hours.opening_time <= CURRENT_TIME() AND operating_hours.closing_time >= CURRENT_TIME() AND operating_hours.day = '. (date('w')-1));
        });

      }
    }

    public function getOpenAttribute($value)
    {
      // Check if in debug mode
      if (config('app.debug')) {
        return true;
      }
      else {
        if ($this->morphMany('App\OperatingHour', 'entry')
                    ->whereRaw('opening_time <= CURRENT_TIME() AND closing_time >= CURRENT_TIME() AND day = '. (date('w')-1))
                    ->first())
        {
          return true;
        }
        else {
          return false;
        }
      }
    }

    public function setOperatingHours($input)
    {
      $this->operatinghours()->delete();
      foreach ($input as $key => $values) {
        $values['day'] = $key;
        $this->operatinghours()->create($values);
      }
    }

    public function saveImage()
    {
      // upload new file
      if (request()->hasFile('imagedl')) {
        $path = 'images/businesses/' . md5(request()->input('name') . microtime()) . '.jpg';
        //$path_storage = public_path('storage/' . $path);
        $image = Image::make(request()->file('imagedl'))->fit(1400, 800)->encode('jpg', 75);
        Storage::put($path, $image->getEncoded(), 'public');
        $this->image_path = $path;
        $this->save();
      // if input is empty — remove file
      } else if((isset(request()->imagedl) && empty(request()->imagedl)) || (isset(request()->imagedl) && !Storage::exists(request()->imagedl))){
        $default = null;
        if ($this->image_path != $default) {
          Storage::delete($this->image_path);
        }
        $this->image_path = null;
        $this->save();
      }
    }

  // Overrides
    public static function create(array $attributes = [])
    {
        $entry = (new static)->newQuery()->create($attributes);

        $tags = (isset($attributes['tags']) && is_array($attributes['tags'])) ? $attributes['tags'] : [];
        $entry->syncTags($tags);

        $entry->setOperatingHours($attributes['operatinghours']);
        $entry->saveImage();

        if (Auth::user()->hasRole('Business')) {
          $entry->users()->save(Auth::user());
        }

        //create new main menu for business
        $entry->createMainMenu();

        return $entry;
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update($attributes);

        $tags = (isset($attributes['tags']) && is_array($attributes['tags'])) ? $attributes['tags'] : [];
        $this->syncTags($tags);

        $this->setOperatingHours($attributes['operatinghours']);
        $this->saveImage();

        //create new main menu if not exists
        if (!$this->menus()->where('main', 1)->first()) {
          $this->createMainMenu();
        }

        return $this;
    }

    public function delete()
    {
      foreach ($this->menuitems() as $menuitem) {
        $menuitem->extras()->delete();
      }
      $this->menuitems()->delete();
      $this->tags()->detach();

      foreach ($this->transactions as $transaction) {
        foreach ($transaction->items() as $transactionitem) {
          $transactionitem->transactionextras()->delete();
        }
      }
      foreach ($this->transactions() as $transaction) {
        $transaction->items()->delete();
      }
      $this->transactions()->delete();

      $this->operatinghours()->delete();

      if ($this->image_path) {
        Storage::delete($this->image_path);
      }
      foreach ($this->users as $user) {
        $user->business_id = NULL;
        $user->save();
      }

      parent::delete();
    }


    public function syncTags($tags)
    {
      $tags = collect($tags)
        ->filter()
        ->map(function ($tag) {
          return Tag::firstOrCreate(['name' => strtolower($tag)])->id;
        })
        ->all();
      $this->tags()->sync($tags);
    }


    public function createMainMenu()
    {
      $this->menus()->create([
        'name' => 'Main',
        'main' => true,
      ]);
    }

}
