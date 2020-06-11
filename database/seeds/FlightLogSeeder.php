<?php

use Illuminate\Database\Seeder;

class FlightLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('/home/milad72t/Public/Laravel/FlightTracker/storage/dataset/airports.dat.txt', 'r');
        $flightLogs = [];
        $flightId = 1;
        while (($line = fgetcsv($file)) !== FALSE && $flightId <= 1500) {
            array_push($flightLogs,[
                'flightId' => $flightId ,
                'altitude' => rand(200,1000),
                'speed' => rand(200,500),
                'angle' => rand(0,350) ,
                'sendTime' => \Carbon\Carbon::now()->toDateTimeString() ,
                'latitude' => str_replace('"','',$line[6]) ,
                'longitude' => str_replace('"','',$line[7]) ,
            ]);
            $flightId++;
        }
        fclose($file);
        $chunks = array_chunk($flightLogs,500);
        foreach ($chunks as $chunk)
            \App\FlightLog::insert($chunk);
    }
}
