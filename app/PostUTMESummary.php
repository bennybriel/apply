<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostUTMESummary extends Model
{
    //
    protected $fillable=[
        'id',
        'postutmescore',
        'olevel',
        'utmescore',
        'utme',
        'status',
        'session',
        'total',
        'name',
        'programme',
        'state'
    ];
}
