<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sjs', function (Blueprint $table) {
            $table->increments('id');
            $table->date('tanggal_delivery');
            $table->string('customer_name');
            $table->string('pdsnumber');
            $table->string('doaii');
            $table->datetime('sj_balik')->nullable();
            $table->datetime('terima_finance')->nullable();
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
        Schema::drop('sjs');
    }
}
