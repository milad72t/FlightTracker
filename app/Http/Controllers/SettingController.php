<?php

namespace App\Http\Controllers;

use App\Setting;
use App\UserPin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function apiGetAllSettings(){
        return response()->json([
            'status' => 200,
            'data' => Setting::all()
        ]);
    }

    public function apiUpdateSettings(Request $request){
        foreach ($request->all() as $key=>$value)
            Setting::where('name',$key)->update(['value'=>$value]);
        return response()->json([
            'status' => 200,
            'msg' => 'به روز رسانی تنظیمات با موفقیت انجام شد'
        ]);
    }

    public function apiAddPin(Request $request){
        $validator = Validator::make($request->all(),[
            'userId' => 'required | integer | exists:users,id',
            'name' => 'required | string | max:30',
            'type' => 'required | integer',
            'latitude' => 'required | numeric',
            'longitude' => 'required | numeric',
        ]);
        if($validator->passes()){
            $userPin = new UserPin();
            $userPin->set($request->get('userId'),$request->get('name'),$request->get('type'),
                $request->get('latitude'),$request->get('longitude'));
            Cache::forget('UserPins_'.$request->get('userId'));
            return response()->json([
                'status' => 200,
                'msg' => 'مکان شما با موفقیت اضافه گردید'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'msg' => $validator->messages()
            ]);
        }
    }

    public function apiRemovePin($pin_id){
        $userPin = UserPin::find($pin_id);
        if($userPin){
            $userPin->delete();
            Cache::forget('UserPins_'.$userPin->user_id);
            return response()->json([
                'status' => 200,
                'msg' => 'مکان شما با موفقیت حذف گردید'
            ]);
        }else{
            return response()->json([
                'status' => 417,
                'msg' => 'چنین مکانی وجود ندارد'
            ]);
        }
    }
}
