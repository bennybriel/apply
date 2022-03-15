<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UGParentInfo extends Model
{
    //
    protected $table = 'u_g_parent_infos';
	public $timestamps = true;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'surname', 'othername','phone','email', 'address','matricno','relation','guid'
	];
}
