<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Route;
use Validator;

class AuthController extends Controller
{

    public function apiLogin(Request $request){
        $data = [
            "username" => Input::get('username'),
            "password" => Input::get('password')
        ];
        $rules = [
            "username" => "required | string | max:30",
            "password" => "required | string | max:60",
        ];
        $messages = [
            "required" => "لطفا تمام فیلدها را پر کنید",
        ];
        $validator = Validator::make($data, $rules, $messages);
        if($validator->passes()) {
            $user = User::where(['username' => $data['username']])->first();
            if ($user && (Hash::check($data['password'] , $user->password))){
                $user->lastLogin = Carbon::now()->toDateTimeString();
                $user->save();
                return response()->json([
                    'status' => 200,
                    "id" => $user->id,
                    "firstName" => $user->firstName,
                    "lastName" => $user->lastName
                ]);
            }else{
                return response()->json([
                    'status' => 417,
                    'msg' => 'نام کاربری یا گذرواژه نادرست است'
                ]);
            }
        }else{
            return response()->json([
                'status' => 401,
                'msg' => $validator->messages()
            ]);
        }
    }


    public function postLoginPage(Request $request)
    {
        if($request->ajax()) {
            $request = Request::create('/api/login', 'POST');
            $response = Route::dispatch($request)->getData();
            if ($response->status == 200) {
                Auth::loginUsingId($response->id);
                session()->put('name',$response->firstName." ".$response->lastName);
                return response()->json([
                    'login_status' => 1
                ]);
            } else {
                return response()->json([
                    'login_status' => 0,
                    'message' => $response->msg
                ]);
            }
        }
    }
}
