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
    //前月のCarbonインスタンスを作成
    $last_month = Carbon::now()->startOfMonth()->subMonth(1);
    //前月の日数を取得
    $last_month_days = $last_month->daysInMonth;
    //前月のCarbonインスタンスを作成
    $users = new User;
    //日数分のダミーデータ全ユーザー分を作成
    for ($i = 0; $i < $last_month_days; $i++) {
      for ($j = 1; $j <= $users->count(); $j++) {
        Attendance::factory()->create(['user_id' => $j, 'insert_date' => $last_month->format('Y-m-d')]);
      }
      $last_month->addDays(1);
    }
  }
}
