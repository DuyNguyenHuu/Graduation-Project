<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blogs;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class BlogController extends Controller
{
    public function index(){
        $getBlog=DB::table('blogs')
                    ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
                    ->select('*')->get();
        return view('blogs.blogs.indexBlog', compact('getBlog'));
    }
    public function create(){
        $getCategoryBlog=DB::table('bcategories')->select('*')->get();
        return view('blogs.blogs.addBlog', compact('getCategoryBlog'));
    }
    public function edit($idBlog){
        $blogShow=DB::table('blogs')->where('IdBlog', '=', $idBlog)
                    ->join('bcategories', 'bcategories.IdBCategory', '=', 'blogs.CategoryBlog')
                    ->select('*')->first();
        $categoryBlogShow=DB::table('bcategories')->select('*')->get();
        return view('blogs.blogs.updateBlog', compact('blogShow', 'categoryBlogShow'));
    }
    public function store(Request $request){
        $request->validate([
            'nameBlog'=>'required|max:255',
            'idBlog'=>'required|max:255'
        ]);

        $cleanHtmlBlog = Purifier::clean($request->descriptionBlog);

        $blog = new Blogs();
        $blog->IdBlog = $request->input('idBlog');
        $blog->Blog = $request->input('nameBlog');
        $blog->ImageBlog = $request->input('imageBlog');
        $blog->DescriptionBlog = $cleanHtmlBlog;
        $blog->CategoryBlog = $request->input('categoryBlog');
        $blog->StatusBlog = $request->input('statusBlog');
        $blog->save();
        return redirect('/blogs');
    }
    public function update(Request $request, $idBlog){
        $request->validate([
            'nameBlog'=>'required|max:255',
            'idBlog'=>'required|max:255'
        ]);
        $htmlBlog = Purifier::clean($request->descriptionBlog);
        $blogUpdate=DB::table('blogs')->where('idBlog', $idBlog)
                        ->update([
                            'Blog'=>$request->input('nameBlog'),
                            'IdBlog'=>$request->input('idBlog'),
                            'StatusBlog'=>$request->input('statusBlog'),
                            'ImageBlog'=>$request->input('imageBlog'),
                            'StatusBLog'=>$request->input('statusBlog'),
                            'DescriptionBlog'=>$htmlBlog
                        ]);
        return redirect('/blogs');
    }
    public function destroy($idBlog){
        $blogDelete=DB::table('blogs')->where('idBlog', $idBlog)
                        ->delete();
        return redirect('/blogs');
    }
}