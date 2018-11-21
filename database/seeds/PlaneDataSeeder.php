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
        $records = [['name'=>'Airbus A310','IATA_Code'=>'310','ICAO_Code'=>'A310'],
            ['name'=>'Antonov An-158','IATA_Code'=>'A58','ICAO_Code'=>'A158'],
            ['name'=>'Boeing 707','IATA_Code'=>'703','ICAO_Code'=>'B703'],
            ['name'=>'Tupolev Tu-154','IATA_Code'=>'TU5','ICAO_Code'=>'T154'],
            ['name'=>'Canadair Regional Jet 1000','IATA_Code'=>'CRK','ICAO_Code'=>'CRJX'],
            ['name'=>'Ilyushin IL96','IATA_Code'=>'I93','ICAO_Code'=>'IL96'],
            ['name'=>'Douglas DC-9-10','IATA_Code'=>'D91','ICAO_Code'=>'DC91'],
            ['name'=>'Fokker 50','IATA_Code'=>'F50','ICAO_Code'=>'F50'],
            ['name'=>'Yakovlev Yak-40','IATA_Code'=>'YK4','ICAO_Code'=>'YK40'],
            ['name'=>'Aerospatiale/Alenia ATR 42-500','IATA_Code'=>'AT5','ICAO_Code'=>'AT45']];
        foreach ($records as $record){
            \App\AirPlane::create($record);
        }
    }
}
