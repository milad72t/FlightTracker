<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/test', function () {
    $file = fopen('/home/milad72t/Public/Laravel/FlightTracker/storage/dataset/airlines.dat.txt', 'r');
    while (($line = fgetcsv($file)) !== FALSE) {
        if(strlen($line[4]) > 4)
            dump(1,$line[4]);
    }
    fclose($file);

    dd(1);
    dd(\Illuminate\Support\Facades\Auth::user()->permittedFormsName());
    $request = \Illuminate\Http\Request::create('/searchFlight','POST');
    $request->merge(['flightId'=>11]);
    echo \Illuminate\Support\Facades\Route::dispatch($request);
    dd(\App\General::getShamsiDate(\Carbon\Carbon::now()));
    $flight = \App\Flight::find(1);
    dd($flight->layerFlightLatLng());
    dd(\App\General::getAllActiveAirports());
});


Route::get('/', function () {
    if (Auth::check()){
        return redirect('/dashboard') ;
    }
    return redirect('/login') ;
});

Route::get('/login',function (){
    return view('login');
})->name('login');

Route::post('/login', 'AuthController@postLoginPage');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/simpleView',function (){
        return view('test');
    });
    Route::get('/dashboard',function (){
        return view('dashboard');
    });
    Route::get('/setNewFlight','ViewController@getNewFlightPage');
    Route::post('/setNewFlight','ViewController@postNewFlightPage');
    Route::get('/dashboard/changePassword','ViewController@getChangePassword');
    Route::post('/dashboard/changePassword','ViewController@postChangePassword');
    Route::get('/searchFlight','ViewController@getSearchFlight');
    Route::post('/searchFlight','ViewController@postSearchFlight');
    Route::get('/users/create','ViewController@getCreateUser');
    Route::post('/users/create','ViewController@postCreateUser');
    Route::get('/users/show','ViewController@getUsersShow');
    Route::get('/airports/show','ViewController@getAirportsShow');
    Route::get('/airlines/show','ViewController@getAirlinesShow');
    Route::get('/loginLogs/show','ViewController@getLoginLogs');
    Route::get('/settings/show','ViewController@getSettingShow');
    Route::post('/settings/show','ViewController@postSettingShow');
    Route::get('/airlines/add','ViewController@getAddAirline');
    Route::post('/airlines/add','ViewController@PostAddAirline');
    Route::get('/airports/add','ViewController@getAirportAdd');
    Route::post('/airports/add','ViewController@postAirportAdd');


});


Route::get('/logout' , function (){
    session()->flush();
    Auth::logout();
    return redirect('/login');
});

Route::get('cleanCache', function (Request $request){
    Cache::flush();
    Artisan::call('cache:clear');
    dd('All Caches was deleted');
});