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
      $Attendances = Attendance::where('insert_date', $date)
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
      $Attendances = Attendance::where('user_id', $user_id)
        // 年-月-日のデータから、年-月%（オールマイティ）で絞り込み
        ->where('insert_date', 'like', "$year_month%")
        ->with(['user', 'note'])
        ->get();
    } else {
      $Attendances = Attendance::whereHas('user', function ($query) {
        $query;
      })->with(['user', 'note'])->get();
    }
    return new AttendanceCollection($Attendances);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $Attendance = Attendance::create($request->all());
    return new AttendanceResource($Attendance);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $Attendance = Attendance::findOrFail($id);
    return new AttendanceResource($Attendance);
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
    $Attendance = Attendance::findOrFail($id);
    $Attendance->update($request->all());
    return new AttendanceResource($Attendance);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    Attendance::findOrFail($id)->delete();
    return response('Deleted successfully.', 200);
  }
}
