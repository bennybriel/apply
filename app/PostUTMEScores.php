<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostUTMEScores extends Model
{
    //
    protected $fillable =[
        'id',
        'utme',
        'session',
        'score'
        
    ];
}
