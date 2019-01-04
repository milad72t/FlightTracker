<?php

namespace App\Http\Controllers;

use App\Setting;
use Illuminate\Http\Request;

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
}
