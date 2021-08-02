<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Attendance extends JsonResource
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
        'type' => 'attendances',
        'attribute' => [
          'id' => $this->id,
          'user_id' => $this->user_id,
          'school_id' => $this->user->school->id,
          'note_id' => $this->note_id,
          'user_name' => $this->user->name,
          'note' => !!$this->note_id ? $this->note->note : null,
          'insert_date' => $this->insert_date,
          'start' => $this->start,
          'end' => $this->end,
          'food_fg' => $this->food_fg,
          'outside_fg' => $this->outside_fg,
          'medical_fg' => $this->medical_fg,
        ]
      ],
      'links' => [
        'self' => url('/api/attendances/' . $this->id),
      ]
    ];
  }
}
