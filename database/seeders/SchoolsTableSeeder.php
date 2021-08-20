<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $schools = ['本校', '本町２校'];
    foreach ($schools as $school) {
      DB::table('schools')->insert([
        'school_name' => $school,
      ]);
    }
  }
}
