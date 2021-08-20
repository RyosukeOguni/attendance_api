<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
  protected $guarded = [
    'id',
  ];
  // 従テーブルの設定
  public function attendance()
  {
    return $this->hasMany('App\Models\Attendance');
  }
}
