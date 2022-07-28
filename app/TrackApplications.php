<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TrackApplications extends Model
{
    //
    protected $table ='trackapplications';
    protected $fillable =
    [
        'matricno','surname','firstname','othername','email','dob','session','apptype',
        'gender','state','lga','phone','category1','category2'
    ];
}
