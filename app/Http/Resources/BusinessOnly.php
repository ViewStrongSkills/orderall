<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Tag as TagResource;
use Storage;

class BusinessOnly extends JsonResource
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
          'addressLine1' => $this->addressLine1,
          'addressLine2' => $this->addressLine2,
          'locality' => $this->locality,
          'latitude' => $this->latitude,
          'longitude' => $this->longitude,
          'image_path' => Storage::url($this->image_path),
          'open' => $this->open,
          'current_open_hours' => $this->currentOpeningHours,
          'reviews' => $this->shortreviews,
          'tags' => TagResource::collection($this->tags),
          ];
    }
}
