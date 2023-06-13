<?php

namespace App\Http\Controllers;
use App\Models\persons;
use App\Models\life_story;
use App\Models\nobel_prizes;
use App\Models\person_nobel;





use Illuminate\Http\Request;

class webController extends Controller
{
    public function person() {
        $user=persons::where('id',1)->get();
        $life=$user->first()->life_story;
        $nobel=$user->first()->nobel;
        return response()->json([$user]);
    }
    
    public function nobel() {
        $user=persons::where('id',1)->get();
        foreach($user as $user) {
            $nobel[]=$user->nobel;
        }
        // $nobel=$user->first()->nobel;
        return response()->json([$user]); 
    }
    public function test() {
        $user=persons::find(1);
        $img=$user->img;
        return response()->json($user);
    }
 
}
