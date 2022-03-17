<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolInfo extends Model
{
    //
    protected $table = 'schoolinfo';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'startdate','enddate','status','matricno'
	];
}
