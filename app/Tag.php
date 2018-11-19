<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{

	protected $fillable = ['name'];

  public function getRouteKeyName()
  {
    return 'name';
  }

	public function businesses()
	{
		return $this->belongsToMany('App\Business');
	}

	public static function mostUsed(int $limit = 15) 
	{
		return static::select('tags.id', 'tags.name')
			->join('business_tag', 'tags.id', '=', 'business_tag.tag_id')
			->selectRaw('count(business_tag.tag_id) as aggregate')
			->groupBy('tags.id', 'tags.name')
			->orderBy('aggregate', 'desc')
			->limit($limit)
			->pluck('name', 'name');
	}

}
