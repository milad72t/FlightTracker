<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $table = 'form';
    public $timestamps = false;
    protected $guarded = [];
}
