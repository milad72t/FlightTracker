<?php

use Illuminate\Database\Seeder;

class AirlineDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = fopen('/home/milad72t/Public/Laravel/FlightTracker/storage/dataset/airlines.dat.txt', 'r');
        $airlinesDatabase = [];
        while (($line = fgetcsv($file)) !== FALSE) {
            array_push($airlinesDatabase,[
                'name' => str_replace('"','',$line[1]) ,
                'alias' => str_replace('"','',$line[2]) ,
                'IATA_Code' => str_replace('"','',$line[3]) ,
                'ICAO_Code' => str_replace('"','',$line[4]) ,
                'callSign' => str_replace('"','',$line[5]) ,
                'country' => str_replace('"','',$line[6]) ,
                'active' => 1 ,
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now(),
            ]);
        }
        fclose($file);
        $chunks = array_chunk($airlinesDatabase,500);
        foreach ($chunks as $chunk)
            \App\AirLine::insert($chunk);
    }
}
