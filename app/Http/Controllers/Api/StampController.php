<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Attendance as AttendanceResource;

class StampController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // get()->all()で、コレクションをオブジェクトの配列として取得
    // ※get()->toArray()では全て配列化
    $users = User::where('school_id', $request->school_id)->get()->all();
    $attendances = Attendance::where('insert_date', Carbon::now()->format('Y-m-d'))->get()->all();

    // 指定所属校の利用者分の配列を生成
    $stamps['data'] = array_map(function ($user) use ($attendances) {
      // 出欠記録に当該利用者が含まれていなければ、$statusはfalse
      // 当該利用者が含まれていて終了時刻が無ければ、$statusは1
      // 当該利用者が含まれていて終了時刻が有れば、$statusは2
      $attendance_id = false;
      $attendance_status = false;
      foreach ($attendances as $attendance) {
        if ($attendance->user_id === $user->id) {
          $attendance_id = $attendance->id;
          $attendance_status = !!$attendance->end ? 2 : 1;
        }
      }
      $stamp = [
        'data' => [
          'type' => 'stamps',
          'attribute' => [
            'id' => $user->id,
            'name' => $user->name,
            'name_kana' => $user->name_kana,
            'attendance_id' => $attendance_id,
            'attendance_status' => $attendance_status,
          ],
          'links' => [
            'self' => url('/api/stamps/' . $user->id)
          ]
        ],
      ];
      return $stamp;
    }, $users);
    return response()->json($stamps);
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
    return response()->json($this->Stamp($attendance));
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
      return response('Not found.', 404);
    }
    $attendance->update($request->all());
    return response()->json($this->Stamp($attendance));
  }

  // POST,PUT時のレスポンスJSON
  function Stamp($attendance)
  {
    return [
      'data' => [
        'type' => 'stamps',
        'attribute' => [
          'id' => $attendance->user->id,
          'name' => $attendance->user->name,
          'name_kana' => $attendance->user->name_kana,
          'attendance_id' => $attendance->id,
          'attendance_status' => !!$attendance->end ? 2 : 1,
        ],
        'links' => [
          'self' => url('/api/stamps/' . $attendance->user->id)
        ]
      ],
    ];
  }
}
