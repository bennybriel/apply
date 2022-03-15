<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiodataUpdateLogger extends Model
{
    //
    protected $table = 'biodataupdatelogger';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'matricno', 'payload','utme','status'
	];
}
