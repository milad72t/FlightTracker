<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AirLine extends Model
{
    protected $table = 'airlines';

    public function set($name,$alias,$IATA_Code,$ICAO_Code,$callSign,$country,$status){
        $this->name = $name;
        $this->alias = $alias;
        $this->IATA_Code = $IATA_Code;
        $this->ICAO_Code = $ICAO_Code;
        $this->callSign = $callSign;
        $this->country = $country;
        $this->active = $status;
        return $this->save();
    }
}
