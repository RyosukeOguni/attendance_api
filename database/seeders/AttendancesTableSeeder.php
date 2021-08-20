<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    //今月初日のCarbonインスタンスを作成
    $this_month = Carbon::now()->startOfMonth();
    //今月の日数を取得
    $this_month_days = $this_month->daysInMonth;
    //今月のCarbonインスタンスを作成
    $users = new User;
    //日数分のダミーデータ全ユーザー分を作成
    for ($i = 0; $i < $this_month_days; $i++) {
      for ($j = 1; $j <= $users->count(); $j++) {
        Attendance::factory()->create(['user_id' => $j, 'insert_date' => $this_month->format('Y-m-d')]);
      }
      // 1日繰り上げ
      $this_month->addDays(1);
    }
  }
}
