<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $appends = ['UserStatus','LastLoginSh','CreatedAtSh'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function set($firstName,$lastName,$userName,$password,$status){
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $userName;
        $this->password = Hash::make($password);
        $this->status = $status;
        return $this->save();
    }

    public function getUserStatusAttribute(){
        if($this->status ==1)
            return 'فعال';
        elseif($this->status == 2)
            return 'غیرفعال';
        else
            return 'نامشخص';
    }

    public function getLastLoginShAttribute(){
        return General::getShamsiDate($this->lastLogin);
    }

    public function getCreatedAtShAttribute(){
        return General::getShamsiDate($this->created_at);
    }

    public function permittedForms(){
        return $this->belongsToMany(Form::class,'user_form_access');
    }

    public function permittedFormsName(){
        return array_column($this->permittedForms->toArray(),'name');
    }
}
