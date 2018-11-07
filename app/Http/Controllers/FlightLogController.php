<?php

namespace App\Http\Controllers;

use App\FlightLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class FlightLogController extends Controller
{

    public function apiGetLiveFlightsLog(Request $request){
        $validator = Validator::make($request->all() , [
            'CenterLat' => 'required | numeric',
            'CenterLong' => 'required | numeric',
            'ZoomLevel' => 'required | integer'
        ]);
        if($validator->passes()){
            $flightLogs = FlightLog::whereNotExists(function ($query){
                $query->select(DB::raw(1))
                    ->from('flight_logs as temp')
                    ->whereRaw('temp.flightId = flight_logs.flightId')
                    ->whereRaw('temp.sendTime > flight_logs.sendTime');
            })->select('flightId','altitude','speed','angle','latitude','longitude')->get();
            return response()->json([
                'status' => 200,
                'data' => $flightLogs
            ]);
        }else{
            return response()->json([
               'status' => 401,
                'msg' => $validator->messages()
            ]);
        }
    }
}
