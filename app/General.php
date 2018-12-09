<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Morilog\Jalali\CalendarUtils;

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
            return Cache::remember('AirportName_' . $airportId, 60 * 24 * 7, function () use ($airportId) {
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
            return Cache::remember('AirplaneName_' . $airplaneId, 60 * 24 * 7, function () use ($airplaneId) {
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

    public static function getGregDate($shamsiDate){
        try {
            $date = explode('/', $shamsiDate);
            $gDate = CalendarUtils::toGregorian($date[0], $date[1], $date[2]);
            return Carbon::create($gDate[0], $gDate[1], $gDate[2])->toDateString();
        }catch (\Exception $e){
            return null;
        }
    }

    public static function getAllActiveAirlines(){
        return Cache::remember('AllActiveAirlines', 60 * 24 * 7, function () {
            $airlines = [];
            foreach (AirLine::where('active',1)->get() as $airline){
                array_push($airlines , ['id'=>$airline->id , 'name'=>$airline->name]);
            }
            return $airlines;
        });
    }

    public static function getAllAirPlanes(){
        return Cache::remember('AllAirPlanes', 60 * 24 * 7, function () {
            $airPlanes = [];
            foreach (AirPlane::all() as $airplane){
                array_push($airPlanes , ['id'=>$airplane->id , 'name'=>$airplane->name]);
            }
            return $airPlanes;
        });
    }

    public static function getAllActiveAirports(){
        return Cache::remember('AllActiveAirports', 60 * 24 * 7, function () {
            $airPorts = [];
            foreach (AirPort::where('active',1)->get() as $airPort){
                array_push($airPorts  , ['id'=>$airPort->id , 'name'=>$airPort->name]);
            }
            return $airPorts ;
        });
    }

    public static function getShamsiDate($gregDate,$justDate = false){
        try{
            if($gregDate == null)
                return null;
            if($justDate)
                $dateFormat = 'Y-m-d';
            else
                $dateFormat = 'H:i:s Y-m-d';
            return CalendarUtils::strftime($dateFormat, strtotime($gregDate));
        }catch (\Exception $e){
            return $gregDate;
        }
    }
}
