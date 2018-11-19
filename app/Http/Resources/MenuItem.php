<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MenuExtra as MenuExtraResource;
use Storage;

class MenuItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      return [
          'id' => $this->id,
          'name' => $this->name,
          'price' => $this->price,
          'discount' => $this->discount,
          'category' => $this->category,
          'description' => $this->description,
          'image_path' => Storage::url('images/menuitems/'. $this->image_path .'.jpg'),
          'menu_extras' => MenuExtraResource::collection($this->extras),
          ];
    }
}
