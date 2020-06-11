<?php

use Illuminate\Database\Seeder;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select('ALTER TABLE flights AUTO_INCREMENT = 1');
        $flights = [];
        for ($i=1 ; $i<=2000;$i++){
            array_push($flights,[
                'flightNumber' => strtoupper(str_random(3)).(string)rand(1000,9000),
                'airlineId' => rand(1,6000),
                'airPlaneId' => rand(1,10),
                'sourceAirportId' => rand(1,7000),
                'destinationAirportId' => rand(1,7000),
                'departureTime' => \Carbon\Carbon::now()->toDateTimeString(),
                'finished' => 0,
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
            ]);
        }
        $chunks = array_chunk($flights,500);
        foreach ($chunks as $chunk)
            \App\Flight::insert($chunk);
    }
}
