<?php

namespace App\Http\Controllers;
use App\AirLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;


class AirlinesController extends Controller
{
    public function apiGetAllAirlines(){
        return response()->json([
           'status' => 200,
            'data' => AirLine::all()
        ]);
    }

    public function apiAddAirline(Request $request){
        $validator = Validator::make($request->all(),
            [
               'name' => 'required | string | max:100',
               'alias' => 'nullable | string | max:50',
               'IATA_Code' => 'required | string | max:3',
               'ICAO_Code' => 'nullable | string | max:4',
               'callSign' => 'nullable | string | max:30',
               'country' => 'required | string | max:100',
               'status' => 'required | boolean',
            ]);
        if($validator->passes()){
            $airline = new AirLine();
            $airline->set($request->get('name'),$request->get('alias'),$request->get('IATA_Code'),
                $request->get('ICAO_Code'), $request->get('callSign'),$request->get('country'),
                $request->get('status'));
            Cache::forget('AllActiveAirlines');
            return response()->json([
                'status' => 200,
                'msg' => 'ایرلاین جدید با موفقیت به سامانه اضافه گردید'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }
}
