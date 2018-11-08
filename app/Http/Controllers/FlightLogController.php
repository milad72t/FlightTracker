<?php

namespace App\Http\Controllers;

use App\FlightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class FlightLogController extends Controller
{

    public function apiGetLiveFlightsLog(Request $request){
        $flightLogs_ = FlightLog::
            where('latitude','>',$request->input('south'))->
            where('latitude','<',$request->input('north'))->
            where('longitude','>',$request->input('west'))->
            where('longitude','<',$request->input('east'))->
            whereNotExists(function ($query){
                $query->select(DB::raw(1))
                    ->from('flight_logs as temp')
                    ->whereRaw('temp.flightId = flight_logs.flightId')
                    ->whereRaw('temp.sendTime > flight_logs.sendTime');
            })->select('flightId','sendTime','altitude','speed','angle','latitude','longitude')->get()->unique('flightId');
//        $flightResponse = [];
//        foreach ($flightLogs as $flightLog){
//            if(!array_key_exists($flightLog->flightId,$flightResponse)) {
//                $flightResponse[$flightLog->flightId] = $flightLog->toArray();
//            }elseif ($flightResponse[$flightLog->flightId]['sendTime'] < $flightLog->sendTime){
//                $flightResponse[$flightLog->flightId] = $flightLog->toArray();
//            }
//        }
        return response()->json([
            'status' => 200,
            'data' => $flightLogs_
        ]);

    }
}
