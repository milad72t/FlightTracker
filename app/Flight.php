<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    protected $table = 'flights';
    protected $appends = ['airlineName','sourceAirportName','destinationAirportName','airPlaneName'];
    protected $hidden =['flightLogs'];


    public function set($flightNumber,$airlineId,$airplaneId,$sourceAirportId,$destinationAirportId,$departureTime,$arrivalTime,$finished){
        $this->flightNumber = $flightNumber;
        $this->airlineId = $airlineId;
        $this->airPlaneId = $airplaneId;
        $this->sourceAirportId = $sourceAirportId;
        $this->destinationAirportId = $destinationAirportId;
        $this->departureTime = $departureTime;
        $this->arrivalTime = $arrivalTime;
        $this->finished = $finished;
        return $this->save();
    }

    public function flightLogs(){
        if($this->finished == 0)
            return $this->hasMany(FlightLog::class,'flightId','id');
        else
            return $this->hasMany(FinishedFlightLogs::class,'flightId','id');

    }

    public function lastFlightLog(){
        if($this->finished == 0)
            return $this->hasOne(FlightLog::class,'flightId','id')->orderBy('sendTime','DESC');
        else
            return $this->hasOne(FinishedFlightLogs::class,'flightId','id')->orderBy('sendTime','DESC');
    }

    public function lastNPoint(){
        return $this->flightLogs()->orderBy('sendTime','DESC');
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

    public function layerFlightLatLng(){
        try {
            $flightLogs = $this->flightLogs->toArray();
            $flightLogsCount = count($flightLogs);
            $recordNumber = 100;
            $response = [];
            if ($flightLogsCount <= $recordNumber) {
                foreach ($flightLogs as $flightLog)
                    array_push($response, [(double)$flightLog['latitude'], (double)$flightLog['longitude']]);
            } else {
                for ($i = 1; $i < $recordNumber; $i++) {
                    $key = floor($flightLogsCount / $recordNumber) * $i;
                    $flightLog = $flightLogs[$key];
                    array_push($response, [(double)$flightLog['latitude'], (double)$flightLog['longitude']]);
                }
            }
            return $response;
        }catch (\Exception $e){
            return [];
        }
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
