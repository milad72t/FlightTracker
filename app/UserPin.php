<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPin extends Model
{
    public $table = 'user_pin';
    public $timestamps = false;

    public function set($userId,$name,$type,$lat,$lng){
        $this->user_id = $userId;
        $this->name = $name;
        $this->type = $type;
        $this->latitude = $lat;
        $this->longitude = $lng;
        return $this->save();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
