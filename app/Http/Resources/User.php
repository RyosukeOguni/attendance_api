<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
          'school_is' => $this->school_is,
          'school_name' => $this->school->school_name,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
        ],
      ],
      'links' => [
        'self' => url('/api/users/' . $this->id),
      ]
    ];
  }
}
