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
    dd(\Illuminate\Support\Facades\Auth::user());
    $user = new \App\User();
    $user->firstName = 'میلاد';
    $user->lastName = 'تیموری';
    $user->username = 'milad';
    $user->password = \Illuminate\Support\Facades\Hash::make('123456' );
//    $user->save();
    dd($user);
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

Route::get('logout' , function (){
    session()->flush();
    Auth::logout();
    return redirect('/login');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard',function (){
        return view('dashboard');
    });
});


