<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\blog;

class BlogController extends Controller
{
    public function blog($id) {
        $blog = blog::select(
            'blog.title',
            'blog.author',
            'blog.content',
            'blog.img',
            'blog.status', 
            'blog.id'
        )
        ->where('blog.id', $id)->first();
        return response()->json(['blog' => $blog]);
    }
}