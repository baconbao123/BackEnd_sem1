<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\person_nobel;
use App\Models\nobel_prizes;
use App\Models\persons;
use App\Models\blog;
use Illuminate\Http\Request;

class FeController extends Controller
{
    public function nobelprizes(){
        $pn = person_nobel::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }

    public function show($id) {
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
            'life_story.struggles',
            'persons.img',    
            'persons.pdf',
            'persons.status as personsstatus',
            'life_story.status as lifestatus',
            'nobel_prizes.status as nobelprizesstatus',
        )
        ->join('person_nobel', 'person_id', '=', 'person_nobel.person_id')
        ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
        ->leftJoin('life_story', 'persons.id', '=', 'life_story.person_id')
        ->where('persons.id', $id)
        ->first();

        return response()->json(['persons' => $persons]);
    }

    public function allshow() {
        $persons = persons::select(
            'nobel_prizes.nobel_name',
            'nobel_prizes.nobel_year',
            'nobel_prizes.status',
            'persons.id',
            'persons.name',
            'persons.img',
            'persons.status',
        )
        ->join('person_nobel', 'persons.id', '=', 'person_nobel.person_id')
        ->join('nobel_prizes', 'person_nobel.nobel_id', '=', 'nobel_prizes.id')
        ->get();

        return response()->json(['persons' => $persons]);
    }

    // public function blog($id) {
    //     $blog = blog::select(
    //         'blog.title',
    //         'blog.author',
    //         'blog.content',
    //         'blog.img',
    //         'blog.status', 
    //         'blog.id'
    //     )
    //     ->where('id', $id)->first();
    //     return response()->json(['blog' => $blog]);
    // }

    public function blogs() {
        $blogs = blog::all();
        return response()->json(['blogs' => $blogs]);
    }
}