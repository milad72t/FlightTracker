<?php

namespace App;


use Illuminate\Support\Facades\DB;

class FinishFlight
{
    protected $flight;
    protected $flightId;

    public function __construct($flight){
        $this->flight = $flight;
        $this->flightId = $flight->id;
    }

    public function finish(){
        DB::beginTransaction();
        try{
            $this->markFlightAsFinish();
            $this->moveAllLogs();
            DB::commit();
            return true;
        }catch (\Exception $e){
            DB::rollBack();
            return false;
        }
    }

    public function markFlightAsFinish(){
        $this->flight->finished = 1;
        $this->flight->save();
    }

    public function moveAllLogs(){
        DB::insert('INSERT into finished_flight_logs (SELECT * from flight_logs WHERE flightId = ?)',[$this->flightId]);
        DB::delete('delete from flight_logs where flightId = ?',[$this->flightId]);
    }

}