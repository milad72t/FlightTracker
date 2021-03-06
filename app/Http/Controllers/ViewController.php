<?php

namespace App\Http\Controllers;

use App\Form;
use App\General;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;

class ViewController extends Controller
{
    public function getNewFlightPage(){
        $airplanes = General::getAllAirPlanes();
        return view('set_new_flight')->with('airplanes',$airplanes);
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
        $forms = Form::all();
        return view('create_user')->with('forms',$forms);
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

    public function getLoginLogs(){
        $request = Request::create('/api/getLoginLogs', 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 ){
            $successLogin = [];
            $failedLogin = [];
            foreach ($response->data as $value){
                if($value->type == 1)
                    array_push($successLogin,$value);
                else
                    array_push($failedLogin,$value);
            }
            return view('login_logs')->with(['successLogin'=>$successLogin,'failedLogin'=>$failedLogin]);
        }
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function getSettingShow(){
        $request = Request::create('/api/getAllSettings', 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('settings_show')->with('settings',$response->data);
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function postSettingShow(){
        $request = Request::create('/api/updateSettings', 'post');
        $response = Route::dispatch($request)->getData();
        return redirect()->intended('/settings/show')->with('notification' , $response->msg);
    }

    public function getAddAirline(){
        return view('create_airline');
    }

    public function PostAddAirline(){
        $request = Request::create('/api/addAirline', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/airlines/show')->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/airlines/add')->withInput()->withErrors($response->msg);
    }

    public function getAirportAdd(){
        return view('create_airport');
    }

    public function postAirportAdd(){
        $request = Request::create('/api/addAirport', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/airports/show')->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/airports/add')->withInput()->withErrors($response->msg);
    }

    public function getUserEdit($userId){
        $request = Request::create('/api/getUserInfo/'.$userId, 'GET');
        $response = Route::dispatch($request)->getData();
        $forms = Form::all();
        if($response->status == 200 )
            return view('users_edit')->with(['userInfo'=>$response->data , 'forms'=>$forms]);
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function postUserEdit($userId){
        $request = Request::create('/api/updateUser', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/users/edit/'.$userId)->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/users/edit/'.$userId)->withInput( )->withErrors($response->msg);
    }

    public function getAirlineEdit($airlineId){
        $request = Request::create('/api/getAirlineInfo/'.$airlineId, 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('airline_edit')->with('airlineInfo',$response->data );
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function postAirlineEdit($airlineId){
        $request = Request::create('/api/updateAirline', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/airlines/edit/'.$airlineId)->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/airlines/edit/'.$airlineId)->withInput( )->withErrors($response->msg);
    }

    public function getAirportEdit($airportId){
        $request = Request::create('/api/getAirportInfo/'.$airportId, 'GET');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return view('airport_edit')->with('airportInfo',$response->data );
        else
            return redirect()->intended('/dashboard')->with('notification' , $response->msg);
    }

    public function postAirportEdit($airportId){
        $request = Request::create('/api/updateAirport', 'POST');
        $response = Route::dispatch($request)->getData();
        if($response->status == 200 )
            return redirect()->intended('/airports/edit/'.$airportId)->with('notification' , $response->msg) ;
        else
            return redirect()->intended('/airports/edit/'.$airportId)->withInput( )->withErrors($response->msg);
    }
}
