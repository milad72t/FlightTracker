<?php

namespace App\Http\Controllers;

use App\Flight;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    public function apiGetFlightInfo($flightId){
        $flight = Flight::find($flightId);
        return response()->json([
           'status' => 200,
            'data' => $flight
        ]);
    }
}
