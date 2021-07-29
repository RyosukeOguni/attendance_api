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
  public function index()
  {
    $Attendances = Attendance::all();
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
