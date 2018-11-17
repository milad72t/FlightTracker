<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'flights';
    protected $appends = ['airlineName','sourceAirportName','destinationAirportName','airPlaneName'];


    public function flightLogs(){
        return $this->hasMany(\App\FlightLog::class,'flightId','id');
    }

    public function lastFlightLog(){
        return $this->hasOne(\App\FlightLog::class,'flightId','id')->orderBy('sendTime','DESC');
    }

    public function airline(){
        return $this->hasOne(\App\AirLine::class,'id','airlineId');
    }

    public function airplane(){
        return $this->hasOne(\App\AirPlane::class,'id','airPlaneId');
    }

    public function sourceAirport(){
        return $this->hasOne(\App\AirPort::class,'id','sourceAirportId');
    }

    public function destAirPort(){
        return $this->hasOne(\App\AirPort::class,'id','destinationAirportId');
    }

    //accessors

    public function getAirlineNameAttribute(){
        return General::getAirlineName($this->airlineId);
    }

    public function getSourceAirportNameAttribute(){
        return General::getAirportName($this->sourceAirportId);
    }

    public function getDestinationAirportNameAttribute(){
        return General::getAirportName($this->destinationAirportId);
    }

    public function getAirplaneNameAttribute(){
        return General::getAirplaneName($this->airPlaneId);
    }
}
