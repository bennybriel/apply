<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portals extends Model
{
   // use HasFactory;
    protected $fillable =[
        'ID',
        'portalid','name','status',
        'created_at'
        
    ];
}
