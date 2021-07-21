<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Http\Resources\StampCollection;
use App\Http\Resources\Stamp as StampResource;
use Carbon\Carbon;

class StampController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $users = User::where('school_id', $request->school)->get();
    $attendances = Attendance::where('insert_date', Carbon::now()->format('Y-m-d'))->get();

    $eee = $users->items;
    $stamps = array_map(function ($user) {
      $status = 1;
      $stamp = [
        'name' => $user->name,
        'name_kana' => $user->name_kana,
        'attendance_status' => $status,
      ];
      return $stamp;
    }, $eee);

    return new StampCollection($stamps);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $user = Attendance::create($request->all());
    return new StampResource($user);
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
    // $user = User::findOrFail($id);
    // $user->update($request->all());
    // return new StampResource($user);
  }
}
