<?php
/**
 * Created by PhpStorm.
 * User: milad72t
 * Date: 1/23/19
 * Time: 5:15 PM
 */

namespace App;


use Carbon\Carbon;

class CronJobClass
{
    public function finishFlights(){
        $deactiveFlights = Flight::whereHas('lastFlightLog',function ($query){
            $query->where('sendTime','<',Carbon::now()->subMinute((int)General::getSettingValue('finishFlightTimeout')));
        })->get();
        foreach ($deactiveFlights as $flight){
            $finishFlightClass = new FinishFlight($flight);
            $finishFlightClass->finish();
        }
    }

}