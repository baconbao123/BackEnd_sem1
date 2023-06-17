<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class persons extends Model
{   
    protected $table='persons';
    protected $fillable=['id','name','birthdate','deathdate','gender','national','img'];
    public function life_story() {
        return $this->hasOne(life_story::class,'person_id','person_id');
    }
    public function nobel() {
        return $this->belongsToMany(nobel_prizes::class,person_nobel::class,'person_id','nobel_id');
    }
    public function img() {
        return $this->hasOne(mutiple_images::class,'person_id','id');
    }
    use HasFactory;
}
