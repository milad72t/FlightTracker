<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class General extends Model
{
    public static function getAirlineName($airlineId){
        try {
            return Cache::remember('AirlineName_' . $airlineId, 60 * 24 * 7, function () use ($airlineId) {
                $airline = AirLine::find($airlineId);
                if ($airline)
                    return $airline->name;
                else
                    return 'نامشخص';
            });
        }catch (\Exception $e){
            return null;
        }
    }

    public static function getAirportName($airportId){
        try {
            return Cache::remember('Airport' . $airportId, 60 * 24 * 7, function () use ($airportId) {
                $airport = AirPort::find($airportId);
                if ($airport)
                    return $airport->name;
                else
                    return 'نامشخص';
            });
        }catch (\Exception $e){
            return null;
        }
    }

    public static function getAirplaneName($airplaneId){
        try {
            return Cache::remember('Airport' . $airplaneId, 60 * 24 * 7, function () use ($airplaneId) {
                $airplane = AirPlane::find($airplaneId);
                if ($airplane)
                    return $airplane->name;
                else
                    return 'نامشخص';
            });
        }catch (\Exception $e){
            return null;
        }
    }
}
