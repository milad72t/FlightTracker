<?php

namespace App\Http\Controllers;

use App\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class ViewController extends Controller
{
    public function getNewFlightPage(){
        $airlines = General::getAllActiveAirlines();
        $airplanes = General::getAllAirPlanes();
        $airports = General::getAllActiveAirports();
        return view('set_new_flight')->with(['airlines'=>$airlines,'airplanes'=>$airplanes,'airports'=>$airports]);
    }

    public function postNewFlightPage(){
        $request = Request::create('/api/setNewFlight', 'post');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200)
        {
            return redirect()->back()->with('message', $response->msg);
        }
        else{
            return redirect()->back()->withInput()->withErrors($response->msg);
        }
    }

    public function getChangePassword(){
        return view('change_password')->with('title','تغییر رمز عبور');
    }

    public function postChangePassword(){
        $user = Auth::user();
        $request = Request::create('/api/changePassword/'.$user->id , 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200) {
            return redirect()->intended('/dashboard')->with('notification', $response->msg);
        }
        else{
            return redirect()->back()->withInput()->withErrors($response->msg);
        }
    }
}
