<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class person_nobel extends Model
{
    protected $table='person_nobel';
    protected $fillable=['person_id','nobel_id','motivation','nobel_share'];
 
    use HasFactory;
}
