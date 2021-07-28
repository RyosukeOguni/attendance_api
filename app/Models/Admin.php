<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
  protected $guarded = [
    'id',
  ];
  protected $hidden = [
    'password', 'remember_token',
  ];
}
