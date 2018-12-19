<?php

namespace App\Http\Controllers;

use App\AirLine;

class AirlinesController extends Controller
{
    public function apiGetAllAirlines(){
        return response()->json([
           'status' => 200,
            'data' => AirLine::all()
        ]);
    }
}
