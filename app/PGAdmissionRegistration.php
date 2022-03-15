<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PGAdmissionRegistration extends Model
{
    //
    protected $table = 'pgregistrationprogress';
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
