<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Menu as MenuResource;
use App\Http\Resources\Tag as TagResource;
use App\Http\Resources\OperatingHour as OperatingHourResource;
use App\Http\Resources\Review as ReviewResource;
use Storage;

class Business extends JsonResource
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
          'email' => $this->email,
          'website' => $this->website,
          'addressLine1' => $this->addressLine1,
          'addressLine2' => $this->addressLine2,
          'locality' => $this->locality,
          'postcode' => $this->postcode,
          'latitude' => $this->latitude,
          'longitude' => $this->longitude,
          'image_path' => Storage::url($this->image_path),
          'open' => $this->open,
          'current_open_hours' => $this->currentOpeningHours,
          'operating_hours' => OperatingHour::collection($this->operatinghours),
          'reviews' => $this->shortreviews,
          'tags' => TagResource::collection($this->tags),
          'menus' => MenuResource::collection($this->menus),
          ];
    }
}
