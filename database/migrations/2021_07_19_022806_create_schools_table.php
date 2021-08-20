<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('schools', function (Blueprint $table) {
      $table->bigIncrements('id')->comment('ID');
      $table->string('school_name')->comment('学校名');
      $table->timestamp('created_at')->nullable()->comment('登録日時');
      $table->timestamp('updated_at')->nullable()->comment('更新日時');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('schools');
  }
}
