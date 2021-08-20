<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AttendanceCollection;
use App\Http\Resources\Attendance as AttendanceResource;

class AttendanceController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    if ($request->school_id && $request->date) {
      $school_id = $request->school_id;
      $date = $request->date;
      $attendance = Attendance::where('insert_date', $date)
        // リレーション先のuserが持つschool_idでwhereをかける
        ->whereHas('user', function ($query) use ($school_id) {
          $query->where('school_id', $school_id);
        })
        // リレーションのクエリを一括読込して重複させない
        ->with(['user', 'note'])
        ->get();
    } else if ($request->user_id && $request->year_month) {
      $user_id = $request->user_id;
      $year_month = $request->year_month;
      $attendance = Attendance::where('user_id', $user_id)
        // 年-月-日のデータから、年-月%（オールマイティ）で絞り込み
        ->where('insert_date', 'like', "$year_month%")
        ->with(['user', 'note'])
        ->get();
    } else {
      $attendance = Attendance::whereHas('user', function ($query) {
        $query;
      })->with(['user', 'note'])->get();
    }
    return new AttendanceCollection($attendance);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $attendance = Attendance::create($request->all());
    return new AttendanceResource($attendance);
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
      $attendance = Attendance::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    return new AttendanceResource($attendance);
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
      $attendance = Attendance::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    $attendance->update($request->all());
    return new AttendanceResource($attendance);
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
      $attendance = Attendance::findOrFail($id);
    } catch (\Throwable $e) {
      return response()->json(['message' => 'Not found'], 404);
    }
    $attendance->delete();
    return response()->json(['message' => 'Deleted successfully'], 200);
  }
}
