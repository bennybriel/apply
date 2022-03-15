<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UGRegistrationProgress extends Model
{
    //
    protected $table ="ugregistrationprogress";
    protected $fillable =
    [
        'utme','status','stageid','matricno','paycode'
    ];
}
