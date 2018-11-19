<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Review extends JsonResource
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
          'rating' => $this->rating,
          'content' => $this->content,
          'user' => $this->user->name,
          'created_at' => $this->created_at,
          ];
    }
}
