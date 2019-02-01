<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

    public function apiAddUser(Request $request){
        $validator = Validator::make($request->all(), [
                "FirstName" => "required | string | max:200",
                "LastName" => "required | string | max:200",
                "UserName" => "required | unique:users,username| min:3 | max:12",
                "password" => "required | min:6 | max:12",
                "rePassword" => "required | same:password",
                "UserStatus" => "required | between:1,2 ",
                "FormIds" => "required | array | exists:form,id",
            ],
            [
                "required" => "لطفا تمامی فیلدهای مورد نظر را پر کنید",
                "UserName.unique" => "این نام کاربری قبلا استفاده شده است",
                "UserName.min" => "نام کاربری حداقل باید داری ۳ کلمه باشد",
                "UserName.max" => "نام کاربری حداکثر میتواند داری ۱۲ کلمه باشد",
                "password.min" => "رمز عبور حداقل باید داری ۶ کاراکتر باشد",
                "password.max" => "رمز عبور حداکثر میتواند داری ۱۲ کاراکتر باشد",
                "UserStatus.between" => "مقدار فیلد وضعیت نادرست است",
                "same" => "رمز عبور با تکرار رمز عبور مطابقت ندارد",
                "FirstName.string" => "مقدار فیلد نام به درستی وارد نشده است",
                "LastName.string" => "مقدار فیلد نام خانوادگی به درستی وارد نشده است",
                "FormIds.required" => "لطفا فرم های مجاز دسترسی کاربر را وارد نمایید",
            ]);
        if($validator->passes()){
            $user = new User();
            $user->set($request->get('FirstName'),$request->get('LastName'),$request->get('UserName'),
                $request->get('password'),$request->get('UserStatus'));
            $user->permittedForms()->attach($request->get('FormIds'));
            return response()->json([
                'status' => 200,
                'msg' => 'ساخت کاربر جدید با موفقیت انجام شد'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }

    public function apiGetAllUsers(){
        return response()->json([
            'status' => 200,
            'data' => User::all()
        ]);
    }

    public function apiGetUserInfo($userId){
        $user = User::find($userId);
        if($user)
            $user->permittedForms = $user->permittedFormsId();
        return response()->json([
            'status' => 200,
            'data' => $user
        ]);
    }

    public function apiUpdateUser(Request $request){
        $validator = Validator::make($request->all(), [
            "Id" => "required | integer | exists:users,id",
            "FirstName" => "required | string | max:200",
            "LastName" => "required | string | max:200",
            "UserName" => "required | unique:users,username,".$request->get('Id').",id| min:3 | max:12",
            "password" => "nullable | min:6 | max:12",
            "rePassword" => "nullable | same:password",
            "UserStatus" => "required | between:1,2 ",
            "FormIds" => "required | array | exists:form,id",
        ],
            [
                "required" => "لطفا تمامی فیلدهای مورد نظر را پر کنید",
                "UserName.unique" => "این نام کاربری قبلا استفاده شده است",
                "UserName.min" => "نام کاربری حداقل باید داری ۳ کلمه باشد",
                "UserName.max" => "نام کاربری حداکثر میتواند داری ۱۲ کلمه باشد",
                "password.min" => "رمز عبور حداقل باید داری ۶ کاراکتر باشد",
                "password.max" => "رمز عبور حداکثر میتواند داری ۱۲ کاراکتر باشد",
                "UserStatus.between" => "مقدار فیلد وضعیت نادرست است",
                "same" => "رمز عبور با تکرار رمز عبور مطابقت ندارد",
                "FirstName.string" => "مقدار فیلد نام به درستی وارد نشده است",
                "LastName.string" => "مقدار فیلد نام خانوادگی به درستی وارد نشده است",
                "FormIds.required" => "لطفا فرم های مجاز دسترسی کاربر را وارد نمایید",
            ]);
        if($validator->passes()){
            $user = User::find($request->get('Id'));
            $user->firstName = $request->get('FirstName');
            $user->lastName = $request->get('LastName');
            $user->username = $request->get('UserName');
            $user->status = $request->get('UserStatus');
            if($request->get('password'))
                $user->password = Hash::make($request->get('password'));
            $user->save();
            $user->permittedForms()->attach($request->get('FormIds'));
            Cache::forget('UserPermittedForm_'.$request->get('Id'));
            Cache::forget('PermForms_'.$request->get('Id'));
            return response()->json([
                'status' => 200,
                'msg' => 'به روز رسانی کاربر با موفقیت انجام شد'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }

}
