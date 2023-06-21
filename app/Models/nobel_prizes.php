<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nobel_prizes extends Model
{
    protected $table='nobel_prizes';
    protected $fillable=['id','nobel_year','nobel_name','status'];
    public function person() {
        return $this-> belongsToMany(persons::class,person_nobel::class,'nobel_id','person_id')->withPivot('motivation','nobel_share');
    }

    use HasFactory;
}
