<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Log;

class Menu extends Model
{

		protected $fillable = [
      'opening_time',
      'closing_time',
      'name',
      'business_id',
      'main'
    ];

		// RELATIONS
    public function menuitems()
    {
      return $this->hasMany('App\MenuItem');
    }

    public function business()
    {
      return $this->belongsTo('App\Business');
    }

    public function operatinghours()
    {
      return $this->morphMany('App\OperatingHour', 'entry');
    }

		public function getCurrentOpeningHoursAttribute()
		{
				$currentDow = (Carbon::now()->format('N')) - 1;
				$currentOh = OperatingHour::where('entry_type', 'App\Menu')->where('entry_id', $this->id)->where('day', $currentDow)->first();
				try {
					return 'Open until ' . date('g:i a', strtotime($currentOh->closing_time));
				}
				catch (\Exception $e) {
					Log::error('Error: no Operating Hours for menu' . $this->id . 'in search results.');
					return 'Closed';
				}
		}

    // OVERRIDES
    public static function create(array $attributes = [])
    {
      $entry = (new static)->newQuery()->create($attributes);
      $entry->setOperatingHours($attributes['operatinghours']);

      return $entry;
    }

    public function update(array $attributes = [], array $options = [])
    {
      parent::update($attributes);
      if (isset($attributes['operatinghours']) && is_array($attributes['operatinghours'])) {
        $this->setOperatingHours($attributes['operatinghours']);
      }
      return $this;
    }

    public function delete()
    {
      foreach ($this->menuitems as $item) {
        $item->extras()->delete();
        $item->delete();
      }
      $this->operatinghours()->delete();
      parent::delete();
    }

    public function setOperatingHours($input)
    {
      $this->operatinghours()->delete();
      foreach ($input as $key => $values) {
        $values['day'] = $key;
        $this->operatinghours()->create($values);
      }
    }

		public function scopeOpen($query)
		{
			// Check if in debug mode
			if (config('app.debug')) {
				return $query;
			}
			else {
				return $query->join('operating_hours', 'operating_hours.entry_id', '=', 'menus.id')
					->whereRaw('operating_hours.opening_time <= CURRENT_TIME() AND operating_hours.closing_time >= CURRENT_TIME() AND operating_hours.entry_type = `App\Menu` AND operating_hours.day = '. (date('w')-2));
			}
		}

		// MUTATORS
		public function setNameAttribute($value)
		{
			$this->attributes['name'] = ucfirst($value);
		}

		public function getOpenAttribute($value)
		{
			// Check if in debug mode
			if (config('app.debug')) {
				return true;
			}
			else {
				if ($this->main) {
					return true;
				}
				else {
					try {
						return $this->morphMany('App\OperatingHour', 'entry')
						->whereRaw('opening_time <= CURRENT_TIME() AND closing_time >= CURRENT_TIME() AND day = '. (date('w')-1))
						->first();
					} catch (\Exception $e) {
						return false;
					}
				}
			}
		}

}
