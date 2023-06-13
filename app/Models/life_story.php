<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class life_story extends Model
{   
    protected $table='life_story';
    protected $fillable=[
        'id',
        'person_id',
        'childhood',
        'education',
        'experiment',
        'struggles',
        'time_line',
        'personalities',
        'achievements_detail',
        'quote',
        'books'
    ];
    public function person() {
        return $this-> belongsTo(persons::class,'person_id','id');
    }
    use HasFactory;
}
