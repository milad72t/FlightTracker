<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirPort extends Model
{
    protected $table = 'airports';

    public function set($IATA_code,$ICAO_code,$name,$country,$city,$active,$altitude,$latitude,$longitude){
        $this->IATA_Code = $IATA_code;
        $this->ICAO_Code = $ICAO_code;
        $this->name = $name;
        $this->country = $country;
        $this->city = $city;
        $this->active = $active;
        $this->altitude = $altitude;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->save();
    }

}
