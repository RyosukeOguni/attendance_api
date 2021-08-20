<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotesTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $notes = ['通所', 'Skype', 'メール', '訪問'];
    foreach ($notes as $note) {
      DB::table('notes')->insert([
        'note' => $note,
      ]);
    }
  }
}
