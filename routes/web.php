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
    dd(preg_replace('/[0-9]+/', '', '/airports/edit/5'));
    $user = \App\General::getUserPermittedForm(\Illuminate\Support\Facades\Auth::user());
    dd(array_column($user->toArray(),'url'));
//    dd(\Illuminate\Support\Facades\Route::current());
//    dd(\App\General::getSettingValue('finishFlightTimeout'));
//    $aa = new \App\CronJobClass();
//    dd($aa->finishFlights());
//    $f = new \App\FinishFlight(\App\Flight::find(23));
//    dd($f->finish());
    dd(json_encode([['l able'=>'slam','value'=>1],['lable'=>'fasd','value'=>2]]));
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


Route::group(['middleware' => ['auth',\App\Http\Middleware\CheckAccess::class]], function () {
    Route::get('/simpleView',function (){
        return view('test');
    });
    Route::get('/dashboard',function (){
        return view('dashboard');
    })->name('dashboard');
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
    Route::get('/airlines/edit/{airlineId}','ViewController@getAirlineEdit');
    Route::post('/airlines/edit/{airlineId}','ViewController@postAirlineEdit');
    Route::get('/loginLogs/show','ViewController@getLoginLogs');
    Route::get('/settings/show','ViewController@getSettingShow');
    Route::post('/settings/show','ViewController@postSettingShow');
    Route::get('/airlines/add','ViewController@getAddAirline');
    Route::post('/airlines/add','ViewController@PostAddAirline');
    Route::get('/airports/add','ViewController@getAirportAdd');
    Route::post('/airports/add','ViewController@postAirportAdd');
    Route::get('/airports/edit/{airportId}','ViewController@getAirportEdit');
    Route::post('/airports/edit/{airportId}','ViewController@postAirportEdit');
    Route::get('/users/edit/{userId}','ViewController@getUserEdit');
    Route::post('/users/edit/{userId}','ViewController@postUserEdit');


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