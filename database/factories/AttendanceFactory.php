<?php

namespace Database\Factories;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttendanceFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = Attendance::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    return [
      'note_id' => $this->faker->numberBetween(1, 4),
      'start' => $this->time15Cile($this->faker->dateTimeBetween('09:00', '12:00'))->format('H:i'),
      'end' => $this->time15Cile($this->faker->dateTimeBetween('13:00', '16:00'))->format('H:i'),
      'food_fg' => $this->faker->boolean(50),
      'outside_fg' => $this->faker->boolean(50),
      'medical_fg' => $this->faker->boolean(50),
    ];
  }
  // HH:iiの時間を15分単位で切り上げ計算
  public function time15Cile($time)
  {
    $_hour = $time->format('H');
    $_minute = $time->format('i');
    if ($_minute % 15) {
      $_minute += 15 - ($_minute % 15);
      if ($_minute == 0) {
        $_hour++;
      }
    }
    return $time->setTime($_hour, $_minute, 0);
  }
}
