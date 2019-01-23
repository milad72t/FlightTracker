<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedFlightLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('finished_flight_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('flightId');
            $table->integer('altitude');
            $table->unsignedInteger('speed');
            $table->decimal('angle',4,1)->nullable();
            $table->timestamp('sendTime');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_flight_logs');
    }
}
