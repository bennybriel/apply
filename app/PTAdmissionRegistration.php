<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PTAdmissionRegistration extends Model
{
    //
    //
    protected $table = 'ptregistrationprogress';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'formnumber', 'paycode','stageid','matricno'
	];
}
