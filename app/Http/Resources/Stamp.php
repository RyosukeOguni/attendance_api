<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Stamp extends JsonResource
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
        'type' => $this->getTable(),
        'attribute' => [
          'id' => $this->id,
          'name' => $this->name,
          'name_kana' => $this->name_kana,
          'attendance_status' => $this->attendance_status,
        ]
      ],
      'links' => [
        'self' => url('/api/attendances/' . $this->id),
      ]
    ];
  }
}
