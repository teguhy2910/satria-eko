<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableShipment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
public function up()
    {
        Schema::create('shipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shipment');
            $table->string('sk_shipment');
            $table->string('currency');
            $table->decimal('amount',40,4);
            $table->string('invoice');
            $table->string('supplier');
            $table->string('origin');
            $table->string('vessel');
            $table->integer('jml_kms');
            $table->decimal('gw',40,3);
            $table->string('sat_kms');
            $table->string('bl');
            $table->string('cont');
            $table->string('forwader');
            $table->string('ship_by');
            $table->date('etd');
            $table->date('eta');
            $table->timestamp('pay_pib')->nullable();
            $table->timestamp('cc')->nullable();
            $table->timestamp('aiia')->nullable();
            $table->date('aiia_plan')->nullable();
            $table->string('dept');
            $table->timestamps();                        
        });
    }

    /**
     * plan the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('shipment');
    }
}
