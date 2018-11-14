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
        $counter = 0;
        while (($line = fgetcsv($file)) !== FALSE) {
            try {
                $counter++;
                if ($counter == 1)
                    continue;
                if($counter == 40)
                    break;
                $newAirport = new \App\AirPort();
                $newAirport->set($line[0], $line[0], $line[1], $line[4], $line[2], 1, $line[5], $line[6]);
            }catch (\Exception $e){}
        }
        fclose($file);
    }
}
