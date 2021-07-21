<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
  public function login(Request $request)
  {
    $credentials = $request->validate([
      'email' => 'required',
      'password' => 'required'
    ]);

    if (Auth::attempt($credentials)) {
      return response()->json(['message' => 'Login successful'], 200);
    }

    return response()->json(['message' => 'User not found'], 422);
  }

  public function logout()
  {
    Auth::logout();
    return response()->json(['message' => 'Logged out'], 200);
  }
}
