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