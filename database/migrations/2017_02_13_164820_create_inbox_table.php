<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInboxTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('inboxes', function (Blueprint $table) {
        $table->increments('id');
        $table->text('content');
        $table->integer('hash_id')->unsigned();
        $table->foreign('hash_id')->references('hash')->on('inboxe_groups');
        $table->string('user_name');
        $table->foreign('user_name')->references('name')->on('users');
        $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('inboxes');
    }
}
