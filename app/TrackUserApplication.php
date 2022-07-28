<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackUserApplication extends Model
{
    //
    protected $table ='trackuserapplication';
    protected  $fillable=[
        'email',
        'session',
        'surname',
        'firstname',
        'othername'
    ];
}
