<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('admins', function (Blueprint $table) {
      $table->bigIncrements('id')->comment('ID');
      $table->string('account')->comment('アカウント');
      $table->string('password')->comment('パスワード');
      $table->rememberToken();
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
    Schema::dropIfExists('admins');
  }
}
