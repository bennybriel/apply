<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PGRegistered extends Model
{
    //
      //
      protected $table = 'pgregistered';
      public $timestamps = true;
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
          'name', 'matricno','formnumber', 'course','programme','degree'
      ];
}
