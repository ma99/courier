<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('booking_ref');
            $table->integer('customer_id');            
            // $table->boolean('home_delivery')->default(true);            
            // $table->boolean('shipment_info')->default(false);            
            $table->string('home_delivery', 9);
            $table->boolean('shipment_info')->default(false);
            //$table->string('shipment_info')->default('N/A');            
            //$table->string('receiving_from')->nullable($value = true);
            $table->string('receiving_address')->default('N/A');
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
        Schema::dropIfExists('bookings');
    }
}
