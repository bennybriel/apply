<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LdaapApps extends Model
{
    //
    protected $table = 'ldaapapps';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'appid', 'name'
    ];
}
