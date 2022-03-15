<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestLogger extends Model
{
    //
    protected $fillable =[
        'ID',
        'request',
        'created_at'
        
    ];
}
