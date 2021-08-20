<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
  // ソフトデリートを実装
  use HasFactory, SoftDeletes;
  protected $guarded = [
    'id',
  ];
  // 主テーブルの設定
  public function school()
  {
    return $this->belongsTo('App\Models\School');
  }
  // 従テーブルの設定
  public function attendance()
  {
    return $this->hasMany('App\Models\Attendance');
  }
}
