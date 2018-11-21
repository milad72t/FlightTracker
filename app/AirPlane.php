<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirPlane extends Model
{
    protected $table = 'airplanes';
    protected $guarded = [];


    public function set($name,$IATA_Code,$ICAO_Code){
        $this->name = $name;
        $this->IATA_Code = $IATA_Code;
        $this->ICAO_Code = $ICAO_Code;
        return $this->save();
    }
}
