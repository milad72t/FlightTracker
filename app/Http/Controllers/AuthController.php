<?php

namespace App\Http\Controllers;

use App\LoginLog;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Route;
use Validator;

class AuthController extends Controller
{
    use ThrottlesLogins;
    public $maxAttempts = 4;
    public $decayMinutes = 1;

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
            if ($this->hasTooManyLoginAttempts($request)) {
                $this->fireLockoutEvent($request);
                return response()->json([
                    'status' => 417,
                    'msg' => 'تعداد دفعات ورود ناموفق زیاد! شما ۱ دقیقه معلق شدید'
                ]);
            }
            $user = User::where(['username' => $data['username']])->first();
            if ($user && (Hash::check($data['password'] , $user->password))){
                $user->lastLogin = Carbon::now()->toDateTimeString();
                $user->save();
                $loginLog = new LoginLog();
                $loginLog->set(1,$data['username'],$user->id,$request->ip(),Carbon::now());
                $this->clearLoginAttempts($request);
                return response()->json([
                    'status' => 200,
                    "id" => $user->id,
                    "firstName" => $user->firstName,
                    "lastName" => $user->lastName
                ]);
            }else{
                $this->incrementLoginAttempts($request);
                $loginLog = new LoginLog();
                $loginLog->set(2,$data['username'],null,$request->ip(),Carbon::now());
                return response()->json([
                    'status' => 417,
                    'msg' => 'نام کاربری یا گذرواژه نادرست است'
                ]);
            }
        }else{
            $this->incrementLoginAttempts($request);
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

    public function apiGetLoginLogs(){
        return response()->json([
            'status' => 200,
            'data' => LoginLog::all()
        ]);
    }

    public function username()
    {
        return 'username';
    }
}
