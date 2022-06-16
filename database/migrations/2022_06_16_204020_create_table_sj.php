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
            $table->date('TANGGAL_DELIVERY');
            $table->string('CUSTOMER_NAME');
            $table->string('CYCLE');
            $table->string('PDSNUMBER');
            $table->string('DOAII');
            $table->string('DOAIIA');
            $table->date('LEADER_CHECK')->nullable();
            $table->date('BALIK')->nullable();
            $table->date('RECHEIPT_CHECK')->nullable();
            $table->date('FINANCE')->nullable();
            $table->date('SUPERVISOR')->nullable();
            $table->date('KIRIMAII')->nullable();
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
