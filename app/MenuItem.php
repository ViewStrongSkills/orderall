<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;
use Auth;
use App\MenuExtraCategory;
use Image;

class MenuItem extends Model
{

    protected $fillable = [
      'name',
      'price',
      'discount',
      'description',
      'category',
      'menu_id',
      'image_path',
    ];

    public function business()
    {
      return $this->belongsTo('App\Business');
    }

    public function menu()
    {
      return $this->belongsTo('App\Menu');
    }

    public function cartitems()
    {
      return $this->hasMany('App\CartItem');
    }

    public function cartextras()
    {
      return $this->hasManyThrough('App\CartExtra', 'App\CartItem');
    }

    public function extras()
    {
      return $this->hasMany('App\MenuExtra');
    }

    public function extracategories()
    {
      return $this->hasMany('App\MenuExtraCategory');
    }

    public function extras_categorized()
    {
      return $this->menuextra_categories()->with('menuextras');
    }

    public function current_price()
    {
      if ($this->discount) {
        return $this->price - $this->discount;
      }
      else {
        return $this->price;
      }
    }

    public function extras_uncategorized()
    {
      return $this->hasMany('App\MenuExtra')->where('menu_extra_category_id', 0);
    }

    public function reviews()
    {
      return $this->hasMany('App\Review');
    }

    public function menuextra_categories()
    {
      return $this->hasMany('App\MenuExtraCategory');
    }

    public function getOrderableAttribute()
    {
        if ($this->menu->open && $this->menu->business->open) {
          return true;
        }
        // some additional checks could go here
        return false;
    }

    // MUTATORS
    public function setNameAttribute($value)
    {
      $this->attributes['name'] = ucfirst($value);
    }

    public function setCategoryAttribute($value)
    {
      $this->attributes['category'] = ucfirst($value);
    }


    // OVERRIDES
    public static function create(array $attributes = [])
    {
        $entry = (new static)->newQuery()->create($attributes);
        $entry->saveImage();

        return $entry;
    }

    public function update(array $attributes = [], array $options = [])
    {
        parent::update($attributes);
        $this->saveImage();

        return $this;
    }

    public function delete()
    {
      $this->extras()->delete();
      $this->cartitems()->delete();
      if ($this->image_path) {
        Storage::delete($this->image_path);
      }
      parent::delete();
    }


    // UTILITIES
    public function saveImage()
    {
      // upload new file
      if (request()->hasFile('image')) {
        $image_hash = md5(request()->input('name') . microtime());
        $path = 'images/menuitems/' . $image_hash . '.jpg';
        $path_micro = 'images/menuitems/' . $image_hash . '_low.jpg';
        $image_main = Image::make(request()->file('image'))->fit(700, 400)->encode('jpg', 75);
        $image_micro = Image::make(request()->file('image'))->fit(35, 20)->blur(5)->encode('jpg', 50);
        Storage::put($path, $image_main->getEncoded(), 'public');
        Storage::put($path_micro, $image_micro->getEncoded(), 'public');
        $this->image_path = $image_hash;
        $this->save();
      // if input is empty — remove file
      } else if((isset(request()->image) && empty(request()->image)) || (isset(request()->image) && !Storage::exists(request()->image))){
        $default = null;
        if ($this->image_path != $default) {
          Storage::delete($this->image_path);
        }
        $this->image_path = null;
        $this->save();
      }
    }

    public function manageCategories($category)
    {
      return $this->menuextra_categories()->firstOrCreate(['name' => $category]);
    }


    // public function syncTags($tags)
    // {
    //   $tags = collect($tags)
    //     ->filter()
    //     ->map(function ($tag) {
    //       return Tag::firstOrCreate(['name' => strtolower($tag)])->id;
    //     })
    //     ->all();
    //   $this->tags()->sync($tags);
    // }

    public function reviewedByUser()
    {
      return Auth::user()->reviews()->where('menu_item_id', $this->id)->first();
    }

}
