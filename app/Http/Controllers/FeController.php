<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\person_nobel;
use App\Models\nobel_prizes;
use Illuminate\Http\Request;

class FeController extends Controller
{
    public function nobelprizes(){
        $pn = person_nobel::where('status', 'active')->orderByDesc('created_at')->get();
        return response()->json($pn);
    }
}
