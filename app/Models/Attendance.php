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
    return $this->belongsTo('App\Model\User');
  }
  public function note()
  {
    return $this->belongsTo('App\Model\Note');
  }
}
