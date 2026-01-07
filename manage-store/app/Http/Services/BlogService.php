<?php
namespace App\Http\Services;
use App\Models\Blogs;
use Illuminate\Support\Facades\DB;
use Mews\Purifier\Facades\Purifier;

class BlogService
{
    public function getList($request){
        $query = DB::table('blogs')
            ->join('bcategories', 'blogs.CategoryBlog', '=', 'bcategories.IdBCategory')
            ->select('blogs.*', 'bcategories.BCategory')
            ->orderByDesc('blogs.IdBlog');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('blogs.Blog', 'like', "%{$keyword}%")
                ->orWhere('bcategories.BCategory', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('blogs.StatusBlog', $request->status);
        }

        return $query->paginate(10)->appends($request->all());
    }
    
    public function create(array $data){
        $blog = new Blogs();
        $blog->IdBlog = $data['idBlog'];
        $blog->Blog = $data['nameBlog'];
        $blog->ImageBlog = $data['imageBlog'] ?? null;
        $blog->DescriptionBlog = Purifier::clean($data['descriptionBlog']);
        $blog->CategoryBlog = $data['categoryBlog'];
        $blog->StatusBlog = $data['statusBlog'];
        $blog->save();
    }

    public function update($idBlog, array $data){
        DB::table('blogs')->where('IdBlog', $idBlog)->update([
            'Blog'            => $data['nameBlog'],
            'IdBlog'          => $data['idBlog'],
            'StatusBlog'      => $data['statusBlog'],
            'ImageBlog'       => $data['imageBlog'] ?? null,
            'DescriptionBlog' => Purifier::clean($data['descriptionBlog']),
            'CategoryBlog'    => $data['categoryBlog'],
        ]);
    }

    public function delete($idBlog)
    {
        DB::table('blogs')->where('IdBlog', $idBlog)->delete();
    }
}