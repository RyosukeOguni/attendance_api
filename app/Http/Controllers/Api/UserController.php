<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::with('school')->get();
    return new UserCollection($users);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = User::create($request->all());
    return new UserResource($user);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    try {
      $user = User::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    return new UserResource($user);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    try {
      $user = User::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    $user->update($request->all());
    return new UserResource($user);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    try {
      $user = User::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    $user->delete();
    return response()->json(['message' => 'Deleted successfully'], 200);
  }
}
