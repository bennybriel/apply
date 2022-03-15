<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UTMESubject extends Model
{
    //
    protected $fillable =[
        'id',
        'utme',
        'subject',
        'subjectid',
        'grade',
        'year',
        'examtype',
        'examnumber',
        'ExamSeries'
    ];
}
