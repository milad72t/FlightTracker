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

Route::post('searchAirport','AirportController@apiSearchAirport');

Route::post('setNewFlight','FlightController@apiSetNewFlight');

Route::post('changePassword/{user_id}','UserController@apiChangePassword');

Route::get('setFlightFinished/{flight_id}','FlightController@apiSetFlightFinished');

Route::post('addUser','UserController@apiAddUser');

Route::post('updateUser','UserController@apiUpdateUser');

Route::get('getAllUsers','UserController@apiGetAllUsers');

Route::get('getUserInfo/{userId}','UserController@apiGetUserInfo');

Route::get('getAllAirports','AirportController@apiGetAllAirports');

Route::get('getAllAirportsName','AirportController@apiGetAllAirportsName');

Route::get('getAllAirlines','AirlinesController@apiGetAllAirlines');

Route::get('getAirlineInfo/{airlineId}','AirlinesController@apiGetAirlineInfo');

Route::post('searchAirline','AirlinesController@apiSearchAirline');

Route::get('getLoginLogs','AuthController@apiGetLoginLogs');

Route::get('getAllSettings','SettingController@apiGetAllSettings');

Route::post('updateSettings','SettingController@apiUpdateSettings');

Route::post('addAirline','AirlinesController@apiAddAirline');

Route::post('updateAirline','AirlinesController@apiUpdateAirline');

Route::post('addAirport','AirportController@apiAddAirport');

Route::post('updateAirport','AirportController@apiUpdateAirport');

Route::post('addPin','SettingController@apiAddPin');

Route::get('removePin/{pin_id}','SettingController@apiRemovePin');





