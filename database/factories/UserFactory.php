<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  /**
   * The name of the factory's corresponding model.
   *
   * @var string
   */
  protected $model = User::class;

  /**
   * Define the model's default state.
   *
   * @return array
   */
  public function definition()
  {
    $user_name = $this->faker->kanaName();
    return [
      'name' => $user_name,
      'name_kana' => $user_name,
      'school_id' => $this->faker->numberBetween(1, 2),
    ];
  }
}
