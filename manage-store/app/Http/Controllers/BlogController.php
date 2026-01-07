<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\BlogService;
use App\Http\Requests\UpdateBlogRequest;

class BlogController extends Controller
{
    protected $blogService;
    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index(Request $request){
        $getBlog = $this->blogService->getList($request);
        return view('blogs.blogs.indexBlog', [
            'getBlog' => $getBlog,
            'search'  => $request->search
        ]);
    }


    public function create(){
        $getCategoryBlog=DB::table('bcategories')->select('*')->get();
        return view('blogs.blogs.addBlog', compact('getCategoryBlog'));
    }

    public function store(StoreBlogRequest $request){
        $this->blogService->create($request->validated());
        return redirect('/blogs')->with('success', 'Blog created successfully.');
    }

    public function edit($idBlog){
        $blogShow=DB::table('blogs')->where('IdBlog', '=', $idBlog)
                    ->join('bcategories', 'bcategories.IdBCategory', '=', 'blogs.CategoryBlog')
                    ->select('*')->first();
        $categoryBlogShow=DB::table('bcategories')->select('*')->get();
        return view('blogs.blogs.updateBlog', compact('blogShow', 'categoryBlogShow'));
    }

    public function update(UpdateBlogRequest $request, $idBlog){
        $this->blogService->update($idBlog, $request->validated());
        return redirect('/blogs')->with('success', 'Blog updated successfully.');
    }

    public function destroy($idBlog){
        $this->blogService->delete($idBlog);
        return redirect('/blogs')->with('success', 'Blog deleted successfully.');
    }
}