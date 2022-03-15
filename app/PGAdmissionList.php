<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PGAdmissionList extends Model
{
    //
    protected $table = 'pgadmissionlist';
      public $timestamps = true;
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
          'name', 'matricno','formnumber', 'course','programme','degree','status','session'
      ];
}
