<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UGPreAdmissionReg extends Model
{
    //
    protected $fillable =[
        'ID','Matricno','Surname','Firstname','Othername','Email','Phone','Category1','Category2','State','Maritalstatus',
        'Gender','Session','Date of Birth','Religion',
        'created_at'
        
    ];
}
