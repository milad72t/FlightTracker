<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function apiChangePassword($userId,Request $request){
        $validator = Validator::make($request->all(), [
                "newPassword" => "required | min:5 | max:12 |confirmed"],
                ["required" => "لطفا تمام فیلدها را پر کنید",
                "confirmed" => " رمز عبور با تکرار رمز عبور مطابقت ندارد",
                "min" => "طول رمز عبور باید بزرگتر از 6 کاراکتر باشد",
                "max" => "طول رمز عبور نباید بزرگتر از ۱۲ کاراکتر باشد",
            ]);
        if($validator->passes()){
            $user = User::find($userId);
            if($user) {
                if ((Hash::check($request->get('oldPassword') , $user->password))) {
                    $user->password = Hash::make($request->get('newPassword'));
                    $user->save();
                    return response()->json([
                        'status' => 200,
                        'msg' => 'تغییر رمز عبور با موفقیت انجام شد'
                    ]);
                } else {
                    return response()->json([
                        'status' => 417,
                        'msg' => ["newPassword" =>  ["گذرواژه پیشین شما نادرست است"]]
                    ]);
                }
            }else{
                return response()->json([
                    'status' => 417,
                    'msg' => 'کاربری با این شناسه یافت نشد'
                ]);
            }
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }
}
