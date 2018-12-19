<?php

namespace App\Http\Controllers;

use App\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
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
        if($response->status == 200)
            return redirect()->intended('/dashboard')->with('notification', $response->msg);
        else
            return redirect()->back()->withInput()->withErrors($response->msg);
    }

    public function getSearchFlight(){
        return view ('search_flight');
    }

    public function postSearchFlight(){
        $flightId = Input::get('flightId');
        $request = Request::create('/api/getAllFlightInfo/'.$flightId,'GET');
        $response = Route::dispatch($request)->getData();
        if($response->data)
            return view('flight_info')->with('flightInfo',$response->data);
        else
            return redirect()->back()->withInput()->with('message','پروازی با این شناسه یافت نشد');

    }

    public function getCreateUser(){
        return view('create_user');
    }

    public function postCreateUser(){
        $request = Request::create('/api/addUser', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/users/show')->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/users/create')->withInput()->withErrors($response->msg);
    }

    public function getUsersShow(){
        $request = Request::create('/api/getAllUsers', 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('users_show')->with('users',$response->data);
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg) ;
    }

    public function getAirportsShow(){
        $request = Request::create('/api/getAllAirports', 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('airports_show')->with('airports',$response->data);
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function getAirlinesShow(){
        $request = Request::create('/api/getAllAirlines', 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('airlines_show')->with('airlines',$response->data);
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }
}
