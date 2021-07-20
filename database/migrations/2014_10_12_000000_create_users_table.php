<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('users', function (Blueprint $table) {
      $table->bigIncrements('id')->comment('ID');
      $table->integer('school_id')->comment('所属ID');
      $table->string('name')->comment('名前');
      $table->string('name_kana')->comment('カナ名');
      $table->softDeletes()->comment('削除フラグ');
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
    Schema::dropIfExists('users');
  }
}
