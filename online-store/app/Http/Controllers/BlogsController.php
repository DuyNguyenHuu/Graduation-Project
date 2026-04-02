<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class BlogsController extends Controller
{
    public function index(request $request){

        $getBCategory=Cache::remember('bcategories_all', 3600, function(){
            return DB::table('bcategories')
                    ->where('StatusBCategory', '=', '1')
                    ->select('*')->get();
        });
        if ($request->has('category')) {
            $getBlog = Cache::remember('blogs_category_'.$request->category, 3600, function() use ($request){
                return DB::table('blogs')
                        ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                        ->where('blogs.CategoryBlog', $request->category)
                        ->where('blogs.StatusBlog', '=', '1')
                        ->where('bcategories.StatusBCategory', '=', '1')
                        ->select('*')
                        ->paginate(8);
            });
        } else {
            $getBlog = Cache::remember('blogs_all', 3600, function(){
                return DB::table('blogs')
                        ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                        ->where('blogs.StatusBlog', '=', '1')
                        ->where('bcategories.StatusBCategory', '=', '1')
                        ->select('*')
                        ->paginate(8);
            });
        }
        if ($request->has('searchBlog')) {
            $getBlog = Cache::remember('blogs_search_' . $request->searchBlog, 3600, function() use ($request) {
                return DB::table('blogs')
                            ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                            ->where('blogs.Blog', 'like', '%' . $request->searchBlog . '%')
                            ->where('blogs.StatusBlog', '=', '1')
                            ->where('bcategories.StatusBCategory', '=', '1')
                        ->select('*')
                        ->paginate(8);
            });
        }
        return view('content.blogs', compact('getBlog', 'getBCategory'));
    }

    public function detailBlog($idBlog){
        $detailBlog=Cache::remember('detail_blog_'.$idBlog, 3600, function() use ($idBlog){
            return DB::table('blogs')->where('IdBlog', $idBlog)
                        ->join('bcategories', 'bcategories.IdBCategory', '=', 'blogs.CategoryBlog')
                        ->first();
        });
        return view('content.detailBlog', compact('detailBlog'));
    }
}