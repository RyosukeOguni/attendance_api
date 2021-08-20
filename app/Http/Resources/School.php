<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class School extends JsonResource
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
      'data' => [
        'type' => 'schools',
        'attribute' => [
          'id' => $this->id,
          'school_name' => $this->school_name,
        ],
      ],
      'links' => [
        'self' => url('/api/schools/' . $this->id),
      ]
    ];
  }
}
