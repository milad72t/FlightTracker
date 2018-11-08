<?php

namespace App\Http\Controllers;

use App\FlightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class FlightLogController extends Controller
{

    public function apiGetLiveFlightsLog(Request $request){
        $flightLogs = FlightLog::
                where('latitude','>',$request->input('south'))->
                where('latitude','<',$request->input('north'))->
                where('longitude','>',$request->input('west'))->
                where('longitude','<',$request->input('east'))->
                select('flightId','sendTime','altitude','speed','angle','latitude','longitude')->get();
        $flightResponse = [];
        foreach ($flightLogs as $flightLog){
            if(!array_key_exists($flightLog->flightId,$flightResponse)) {
                $flightResponse[$flightLog->flightId] = $flightLog->toArray();
            }elseif ($flightResponse[$flightLog->flightId]['sendTime'] < $flightLog->sendTime){
                $flightResponse[$flightLog->flightId] = $flightLog->toArray();
            }
        }
        return response()->json([
            'status' => 200,
            'data' => array_values($flightResponse)
        ]);

    }
}
