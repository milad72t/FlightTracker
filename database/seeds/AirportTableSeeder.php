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
        $file = fopen('/home/milad72t/Public/Laravel/FlightTracker/storage/airports.csv', 'r');
        while (($line = fgetcsv($file)) !== FALSE) {
            try {
                $newAirport = new \App\AirPort();
                $newAirport->set($line[4],$line[5],$line[1],$line[3],$line[2],1,$line[6],$line[7]);
            }catch (\Exception $e){
                dump($e->getMessage());
            }
        }
        fclose($file);
    }
}
