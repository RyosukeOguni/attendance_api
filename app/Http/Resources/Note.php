<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Note extends JsonResource
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
        'type' => 'notes',
        'attribute' => [
          'id' => $this->id,
          'note' => $this->note,
        ],
      ],
      'links' => [
        'self' => url('/api/notes/' . $this->id),
      ]
    ];
  }
}
