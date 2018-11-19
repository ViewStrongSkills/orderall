<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OperatingHour extends Model
{

		protected $fillable = ['opening_time', 'closing_time', 'day'];

    public function business()
    {
      return $this->belongsTo('App\Business');
    }

    public function entry()
    {
      return $this->morphTo();
    }

    public static function prepare($operatinghours)
    {
      $result = [];
			if ($operatinghours) {
				foreach ($operatinghours as $key => $value) {
					if (empty($value['opening_time']) && empty($value['closing_time'])) {
						continue;
					}
					$result[$key] = $value;
				}
			}
      return $result;
    }

    public function getOpeningTimeAttribute($value)
    {
      return substr($value, 0,5);
    }

    public function getClosingTimeAttribute($value)
    {
      return substr($value, 0,5);
    }

    public function newCollection(array $models = [])
    {
      $result = [];
      if (!empty($models)) {
        foreach ($models as $m) {
          $result[$m->day] = $m;
        }
      }
      return collect($result);
    }

}
