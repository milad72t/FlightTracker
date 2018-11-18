<?php

namespace App\Http\Controllers;

use App\AirPort;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function apiGetAirportInfo($airportId){
        $airport = AirPort::find($airportId);
        return response()->json([
           'status' => 200,
            'data' => $airport
        ]);
    }
}
