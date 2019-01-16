<?php

use Illuminate\Database\Seeder;

class AirportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('/home/milad72t/Public/Laravel/FlightTracker/storage/dataset/airports.dat.txt', 'r');
        $airportDatabase = [];
        while (($line = fgetcsv($file)) !== FALSE) {
            array_push($airportDatabase,[
                'name' => str_replace('"','',$line[1]) ,
                'city' => str_replace('"','',$line[2]) ,
                'country' => str_replace('"','',$line[3]) ,
                'IATA_Code' => str_replace('"','',$line[4]) ,
                'ICAO_Code' => str_replace('"','',$line[5]) ,
                'latitude' => str_replace('"','',$line[6]) ,
                'longitude' => str_replace('"','',$line[7]) ,
                'altitude' => str_replace('"','',$line[8]) ,
                'active' => 1,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now(),
            ]);
        }
        fclose($file);
        $chunks = array_chunk($airportDatabase,500);
        foreach ($chunks as $chunk)
            \App\AirPort::insert($chunk);
    }
}
