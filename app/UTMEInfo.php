<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UTMEInfo extends Model
{
    protected  $fillable=
    [
        'id',
        'utme',
        'name',
        'gender',
        'state',
        'totalscore',
        'programme',
        'lga',
        'subject1',
        'score1',
        'subject2',
        'score2',
        'subject3',
        'score3',
        'score4',
        'subject4',
        'status',
        'apptype'
    ];
}
