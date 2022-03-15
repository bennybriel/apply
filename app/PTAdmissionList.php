<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PTAdmissionList extends Model
{
    //.
    protected $table = 'ptadmissionlist';
      public $timestamps = true;
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
          'name','formnumber','programme','slevels','session'
      ];
}
