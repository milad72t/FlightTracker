<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'AuthController@apiLogin');

Route::get('getLiveFlightsLog' , 'FlightLogController@apiGetLiveFlightsLog');

Route::get('getFlightInfo/{flightId}','FlightController@apiGetFlightInfo');

Route::get('getAllFlightInfo/{flightId}','FlightController@apiGetAllFlightInfo');

Route::get('getAirportInfo/{airportId}','AirportController@apiGetAirportInfo');

Route::post('setNewFlight','FlightController@apiSetNewFlight');

Route::post('changePassword/{user_id}','UserController@apiChangePassword');

Route::get('setFlightFinished/{flight_id}','FlightController@apiSetFlightFinished');

Route::post('addUser','UserController@apiAddUser');

Route::get('getAllUsers','UserController@apiGetAllUsers');

Route::get('getAllAirports','AirportController@apiGetAllAirports');

Route::get('getAllAirlines','AirlinesController@apiGetAllAirlines');

Route::get('getLoginLogs','AuthController@apiGetLoginLogs');

