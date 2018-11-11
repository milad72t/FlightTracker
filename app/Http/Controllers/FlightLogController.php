<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;
use DB;

class FlightLogController extends Controller
{

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
            'data' => $response
        ]);

    }
}
