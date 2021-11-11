<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForwaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('forwader', function (Blueprint $table) {
          $table->increments('id');
          $table->string('namappjk')->nullable();
          $table->string('npwpppjk')->nullable();
          $table->string('namapimpinanppjk')->nullable();
          $table->string('alamatppjk')->nullable();
          $table->string('telppjk')->nullable();
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
        Schema::drop('forwader');
    }
}
