<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogsController extends Controller
{
    public function index(request $request){
        $getBCategory=DB::table('bcategories')->select('*')->get();
        if ($request->has('category')) {
            $getBlog = DB::table('blogs')
                        ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                        ->where('blogs.CategoryBlog', $request->category)
                        ->select('*')
                        ->paginate(8);
        } else {
            $getBlog = DB::table('blogs')
                        ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                        ->select('*')
                        ->paginate(8);
        }
        return view('content.blogs', compact('getBlog', 'getBCategory'));
    }

    public function detailBlog($idBlog){
        $detailBlog=DB::table('blogs')->where('IdBlog', $idBlog)
                        ->join('bcategories', 'bcategories.IdBCategory', '=', 'blogs.CategoryBlog')
                        ->first();
        return view('content.detailBlog', compact('detailBlog'));
    }
}