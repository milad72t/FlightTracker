<?php

namespace App\Http\Controllers;

use App\AirPort;
use App\Flight;
use App\General;
use App\UserPin;
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

    public function getUserPins($userId){
        return Cache::remember('UserPins_'.$userId,24*60,function ()use($userId){
           return UserPin::where('user_id',$userId)->get()->toArray();
        });
    }

    public function apiGetLiveFlightsLog(Request $request){
        $flightLogs = Flight::with(['lastNPoint','lastFlightLog'])->whereHas('lastFlightLog',function ($query)use($request){
            $query->where('latitude','>',$request->input('south'))->
                where('latitude','<',$request->input('north'))->
                where('longitude','>',$request->input('west'))->
                where('longitude','<',$request->input('east'));
        })->where('finished',false)->select('id','flightNumber','airlineId'
                ,'airPlaneId','sourceAirportId','destinationAirportId','departureTime')->get();
        $pointNumber = (integer)General::getSettingValue('numOfPoinInFlight');
        $response = [];
        foreach ($flightLogs as $flightLog){
            if($flightLog->lastFlightLog){
                array_push($response , [
                    'flightId' => $flightLog->id,
                    'flightNumber' => $flightLog->flightNumber,
                    'altitude' => $flightLog->lastFlightLog->altitude,
                    'speed' => $flightLog->lastFlightLog->speed,
                    'angle' => $flightLog->lastFlightLog->angle,
                    'latitude' => $flightLog->lastFlightLog->latitude,
                    'longitude' => $flightLog->lastFlightLog->longitude,
                    'lastNPoint' => $flightLog->lastNPoint->take($pointNumber)->makeHidden(
                        ['sendTime','angle','speed','altitude','flightId','id'])
                ]);
            }
        }
        return response()->json([
            'status' => 200,
            'flights' => $response,
            'airports' => $request->input('getAirports') == 1 ? $this->getActiveAirportsInfo($request) : [],
            'userPins' => $this->getUserPins($request->input('id'))
        ]);

    }
}
