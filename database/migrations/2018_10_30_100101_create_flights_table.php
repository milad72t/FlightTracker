<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('flightNumber',10);
            $table->integer('airlineId');
            $table->integer('airPlaneId');
            $table->integer('sourceAirportId');
            $table->integer('destinationAirportId');
            $table->dateTime('departureTime');
            $table->dateTime('arrivalTime')->nullable();
            $table->boolean('finished')->default(false);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('flights');
    }
}
