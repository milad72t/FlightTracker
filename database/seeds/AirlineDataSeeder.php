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
        $records =[
          ['name'=>'Iran Air','alias'=>'','IATA_Code'=>'IR','ICAO_Code'=>'IRA','callSign'=>'IRANAIR','country'=>'Iran','active'=>1],
          ['name'=>'Iran Aseman Airlines','alias'=>'','IATA_Code'=>'EP','ICAO_Code'=>'IRC','callSign'=>'','country'=>'Iran','active'=>1],
          ['name'=>'Kish Air','alias'=>'','IATA_Code'=>'Y9','ICAO_Code'=>'IRK','callSign'=>'KISHAIR','country'=>'Iran','active'=>1],
          ['name'=>'ATA Airlines (Iran)','alias'=>'هواپیمایی آتا','IATA_Code'=>'I3','ICAO_Code'=>'','callSign'=>'ATALAR','country'=>'Iran','active'=>1],
          ['name'=>'Mahan Air','alias'=>'','IATA_Code'=>'W5','ICAO_Code'=>'IRM','callSign'=>'MAHAN AIR','country'=>'Iran','active'=>1],
          ['name'=>'All Nippon Airways','alias'=>'ANA All Nippon Airways','IATA_Code'=>'NH','ICAO_Code'=>'ANA','callSign'=>'ALL NIPPON','country'=>'Japan','active'=>1],
          ['name'=>'Qatar Airways','alias'=>'','IATA_Code'=>'QR','ICAO_Code'=>'QTR','callSign'=>'QATARI','country'=>'Qatar','active'=>1],
          ['name'=>'Emirates','alias'=>'Emirates Airlines','IATA_Code'=>'EK','ICAO_Code'=>'UAE','callSign'=>'EMIRATES','country'=>'United Arab Emirates','active'=>1],
          ['name'=>'Etihad Airways','alias'=>'','IATA_Code'=>'EY','ICAO_Code'=>'ETD','callSign'=>'ETIHAD','country'=>'United Arab Emirates','active'=>1],
          ['name'=>'Aeroflot Russian Airlines','alias'=>'','IATA_Code'=>'SU','ICAO_Code'=>'AFL','callSign'=>'AEROFLOT','country'=>'Russia','active'=>1],
          ['name'=>'America West Airlines','alias'=>'','IATA_Code'=>'HP','ICAO_Code'=>'AWE','callSign'=>'CACTUS','country'=>'United States','active'=>1]
        ];
        foreach ($records as $record){
            \App\AirLine::create($record);
        }
    }
}
