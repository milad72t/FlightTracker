<?php

namespace App\Http\Controllers;

use App\FinishFlight;
use App\Flight;
use App\General;
use Illuminate\Http\Request;
use Validator;

class FlightController extends Controller
{
    public function apiGetFlightInfo($flightId){
        $flight = Flight::find($flightId);
        if($flight)
            $flight->layerLatLng = $flight->layerFlightLatLng();
        return response()->json([
           'status' => 200,
            'data' => $flight
        ]);
    }

    public function apiGetAllFlightInfo($flightId){
        $flight = Flight::with(['airline','airplane','sourceAirport','destAirPort'])->find($flightId);
        if($flight){
            $flight->layerFlightLatLng = $flight->layerFlightLatLng();
            $flight->last_flight_log = $flight->lastFlightLog;
        }
        return response()->json([
            'status' => 200,
            'data' => $flight
        ]);
    }

    public function apiSetNewFlight(Request $request){
        $validator = Validator::make($request->all(), [
            'flightNumber'=> 'required | string | max:10',
            'airlineId'=> 'required | integer',
            'airPlaneId'=> 'required | integer',
            'sourceAirportId'=> 'required | numeric',
            'destinationAirportId'=> 'required | numeric',
            'departureTime'=> 'required | regex:/[0-9]{4}\/[0-9]{2}\/[0-9]{2}$/'
                ]);
        if($validator->passes()){
            $flight = new Flight();
            $flight->set($request->get('flightNumber'),$request->get('airlineId'),$request->get('airPlaneId'),
                $request->get('sourceAirportId'),$request->get('destinationAirportId'),
                General::getGregDate($request->get('departureTime')), null,0);
            return response()->json([
                'status' => 200,
                'msg' => str_replace('FlightId',$flight->id,'پرواز شما با شماره شناسه FlightId در سامانه به ثبت رسید')
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }

    public function apiSetFlightFinished($flightId){
        $flight = Flight::find($flightId);
        if($flight){
            $finishFlight = new FinishFlight($flight);
            $status = $finishFlight->finish();
            if($status)
                return response()->json([
                    'status' => 200,
                    'msg' => 'اتمام پرواز مورد نظر در سامانه به ثبت رسید'
                ]);
            else
                return response()->json([
                    'status' => 417,
                    'msg' => 'متاسفانه در انجام درخواست شما مشکلی پیش آمده است'
                ]);
        }else{
            return response()->json([
                'status' => 417,
                'msg' => 'پروازی با این شناسه در سامانه موجود نیست :('
            ]);
        }
    }
}
