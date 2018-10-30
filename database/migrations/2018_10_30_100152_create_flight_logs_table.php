<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlightLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flight_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('flightId');
            $table->integer('altitude');
            $table->unsignedInteger('speed');
            $table->decimal('angle',3)->nullable();
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
        Schema::dropIfExists('flight_logs');
    }
}
