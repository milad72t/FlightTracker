<?php

namespace App\Http\Controllers;

use App\AirPort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class AirportController extends Controller
{
    public function apiGetAirportInfo($airportId){
        $airport = AirPort::find($airportId);
        return response()->json([
           'status' => 200,
            'data' => $airport
        ]);
    }

    public function apiGetAllAirports(){
        return response()->json([
           'status' => 200,
            'data' => AirPort::all()->makeHidden(['created_at','updated_at'])
        ]);
    }

    public function apiGetAllAirportsName(){
        return response()->json([
           'status' => 200,
            'data' => AirPort::select('id','name')->get()
        ]);
    }

    public function apiAddAirport(Request $request){
        $validator = Validator::make($request->all(),
            [
                'name' => 'required | string | max:100',
                'IATA_Code' => 'required | string | max:3',
                'ICAO_Code' => 'nullable | string | max:4',
                'status' => 'required | integer',
                'altitude' => 'nullable | integer',
                'country' => 'required | string | max:50',
                'city' => 'required | string | max:50',
                'latitude' => 'required | numeric',
                'longitude' => 'required | numeric',
            ]);
        if($validator->passes()){
            $airport = new AirPort();
            $airport->set($request->get('IATA_Code'),$request->get('ICAO_Code'),$request->get('name'),
                $request->get('country'),$request->get('city'),$request->get('status'),$request->get('altitude'),
                $request->get('latitude'),$request->get('longitude'));
            Cache::forget('ActiveAirportsInfo');
            Cache::forget('AllActiveAirports');
            return response()->json([
                'status' => 200,
                'msg' => 'اطلاعات فرودگاه مورد نظر با موفقیت به ثبت رسید'
            ]);

        }else{
            return response()->json([
               'status' => 400,
               'msg' => $validator->messages(),
            ]);
        }
    }

    public function apiUpdateAirport(Request $request){
        $validator = Validator::make($request->all(),
            [
                'Id' => 'required | integer | exists:airports,id',
                'name' => 'required | string | max:100',
                'IATA_Code' => 'nullable | string | max:3',
                'ICAO_Code' => 'nullable | string | max:4',
                'status' => 'required | integer',
                'altitude' => 'nullable | integer',
                'country' => 'required | string | max:50',
                'city' => 'required | string | max:50',
                'latitude' => 'required | numeric',
                'longitude' => 'required | numeric',
            ]);
        if($validator->passes()){
            $airport = AirPort::find($request->get('Id'));
            $airport->set($request->get('IATA_Code'),$request->get('ICAO_Code'),$request->get('name'),
                $request->get('country'),$request->get('city'),$request->get('status'),$request->get('altitude'),
                $request->get('latitude'),$request->get('longitude'));
            Cache::forget('ActiveAirportsInfo');
            Cache::forget('AllActiveAirports');
            return response()->json([
                'status' => 200,
                'msg' => 'به روز رسانی اطلاعات فرودگاه مورد نظر با موفقیت انجام شد'
            ]);

        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages(),
            ]);
        }
    }
}
