<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdaapInfo extends Model
{
    //
    protected $table = 'ldaasinfo';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department', 'departmentid','faculty', 'facultyid','appid'
    ];
}
