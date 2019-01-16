<?php

use Illuminate\Database\Seeder;

class PlaneDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $planeFile = \Illuminate\Support\Facades\Storage::disk('dataset')->get('planes.dat.txt');
        $planesArray = explode("\n",$planeFile);
        $planeDatabase = [];
        foreach ($planesArray as $value){
            $plane = explode(',',$value);
            array_push($planeDatabase,[
                'name'=> str_replace('"','',$plane[0]),
                'IATA_Code'=>str_replace('"','',$plane[1]),
                'ICAO_Code'=>str_replace('"','',$plane[2]),
                'created_at'=> \Carbon\Carbon::now(),
                'updated_at'=> \Carbon\Carbon::now(),
            ]);
        }
        \App\AirPlane::insert($planeDatabase);
    }
}
