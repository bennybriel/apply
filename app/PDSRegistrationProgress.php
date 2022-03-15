<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PDSRegistrationProgress extends Model
{
    //
    protected $table = 'pdsregistrationprogress';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'formnumber', 'paycode','stageid','matricno','productid'
	];
}
