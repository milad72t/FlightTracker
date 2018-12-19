<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $table = 'login_log';
    protected $appends = ['typeName','userFullName','timeSh'];
    public $timestamps = false;

    public function set($type,$username,$userId,$ip,$time){
        $this->type = $type;
        $this->username = $username;
        $this->userId = $userId;
        $this->ip= $ip;
        $this->time = $time;
        return $this->save();
    }

    public function getTypeNameAttribute(){
        switch ($this->type){
            case 1:
                return 'ورود موفق';
            case 2:
                return 'گذرواژه اشتباه';
            case 3:
                return 'کاربر غیرفعال شده';
            default:
                return 'نا مشخص';
        }
    }

    public function getUserFullNameAttribute(){
        if($this->userId){
            $user = User::find($this->userId);
            return $user->firstName . ' ' . $user->lastName;
        }else
            return null;
    }

    public function getTimeShAttribute(){
        return General::getShamsiDate($this->time);
    }


}
