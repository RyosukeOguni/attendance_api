<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\SchoolsTableSeeder;
use Database\Seeders\NotesTableSeeder;
use Database\Seeders\AttendancesTableSeeder;
use Database\Seeders\AdminsTableSeeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $this->call(SchoolsTableSeeder::class);
    $this->call(NotesTableSeeder::class);
    $this->call(AdminsTableSeeder::class);
    $this->call(UsersTableSeeder::class);
    $this->call(AttendancesTableSeeder::class);
  }
}
