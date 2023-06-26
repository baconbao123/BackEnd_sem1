<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\person_nobel;
use App\Models\nobel_prizes;
use App\Models\persons;
use Illuminate\Http\Request;

class FeController extends Controller
{
    public function nobelprizes(){
        $pn = person_nobel::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }

    public function show() {
        $persons = persons::select(
            'nobel_prizes.nobel_name',
            'nobel_prizes.nobel_year',
            'persons.national',
            'persons.name',
            'persons.id',
            'persons.birthdate',
            'persons.deathdate',
            'person_nobel.motivation',
            'person_nobel.nobel_share',
            'life_story.life',
            'life_story.experiment',
            'life_story.achievements_detail',
            'life_story.time_line',
            'life_story.quote',
            'persons.img',    
            'persons.pdf'
        )
        ->join('person_nobel', 'person_id', '=', 'person_nobel.person_id')
        ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
        ->leftJoin('life_story', 'persons.id', '=', 'life_story.person_id')
        // ->leftJoin('mutiple_images', 'persons.id', '=', 'mutiple_images.person_id')
        ->get();

        return response()->json(['persons' => $persons]);
    }
}