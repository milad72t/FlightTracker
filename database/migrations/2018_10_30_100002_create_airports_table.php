<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAirportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('airports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('IATA_Code',3)->nullable();
            $table->string('ICAO_Code',4)->nullable();
            $table->string('name',100);
            $table->string('country',100);
            $table->string('city',100);
            $table->boolean('active');
            $table->decimal('latitude', 9, 6);
            $table->decimal('longitude', 9, 6);
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
        Schema::dropIfExists('airports');
    }
}
