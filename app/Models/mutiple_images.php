<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mutiple_images extends Model
{
    protected $table="multiple_images";
    protected $fillable=['id','person_id','title','image_path'];
    public function person(){
        return $this->belongsTo(persons::class,'id','person_id');
    }
    use HasFactory;
}
