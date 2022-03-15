<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //use HasFactory;
    protected $fillable =[
        'ID',
        'catid','name','status',
        'created_at'
        
    ];
}
