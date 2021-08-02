<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
  use HasFactory;
  protected $guarded = [
    'id',
  ];
  //主テーブルの設定
  public function user()
  {
    return $this->belongsTo('App\Models\User')->with('school');
  }
  public function school()
  {
    return $this->belongsTo('App\Models\School');
  }
  public function note()
  {
    return $this->belongsTo('App\Models\Note');
  }
}
