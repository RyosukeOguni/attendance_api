<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
  protected $guarded = [
    'id',
  ];
  // 従テーブルの設定
  public function user()
  {
    return $this->hasMany('App\Models\User');
  }
}
