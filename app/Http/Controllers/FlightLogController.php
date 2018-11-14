<?php

namespace App\Http\Controllers;

use App\AirPort;
use App\Flight;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Cache;

class FlightLogController extends Controller
{

    public function getActiveAirportsInfo($request){
        $airports = Cache::remember('ActiveAirportsInfo',60*24*7,function (){
            return AirPort::where('active',true)->select('id','name','latitude','longitude')->get();
        });
        foreach ($airports as $key=>$airport ){
            if(!($airport->latitude > $request->input('south') && $airport->latitude < $request->input('north') &&
                $airport->longitude > $request->input('west') && $airport->longitude < $request->input('east'))){
                $airports->forget($key);
            }
        }
        return $airports;
    }

    public function isPointInsideWindow($lat,$long,$request){
        if($lat > $request->input('south') && $lat < $request->input('north') &&
            $long > $request->input('west') && $long < $request->input('east')){
            return true;
        }
        return false;
    }

    public function apiGetLiveFlightsLog(Request $request){
        $flightLogs = Flight::with('lastFlightLog')->
            where('finished',false)->select('id','flightNumber','airlineId'
                ,'airPlaneId','sourceAirportId','destinationAirportId','departureTime')->get();
        $response = [];
        foreach ($flightLogs as $flightLog){
            if($flightLog->lastFlightLog){
                if($this->isPointInsideWindow($flightLog->lastFlightLog->latitude,$flightLog->lastFlightLog->longitude,$request)){
                    array_push($response , [
                        'flightId' => $flightLog->id,
                        'flightNumber' => $flightLog->flightNumber,
                        'altitude' => $flightLog->lastFlightLog->altitude,
                        'speed' => $flightLog->lastFlightLog->speed,
                        'angle' => $flightLog->lastFlightLog->angle,
                        'latitude' => $flightLog->lastFlightLog->latitude,
                        'longitude' => $flightLog->lastFlightLog->longitude
                    ]);
                }
            }
        }
        return response()->json([
            'status' => 200,
            'flights' => $response,
            'airports' => $this->getActiveAirportsInfo($request)
        ]);

    }
}
