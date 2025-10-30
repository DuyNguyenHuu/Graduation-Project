<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Categories;
class CategoryController extends Controller
{
    public function index(){
        $categoryList=DB::table('categories')->select('*')->get();
        return view('categories.categories.indexCategory', compact('categoryList'));
    }

    public function create(){
        return view('categories.categories.addCategory');
    }

    public function store(Request $request){
        $request->validate([
            'nameCategory'=>'required',
            'idCategory'=>'required'
        ]);

        $category = new Categories();
        $category->NameCategory = $request->input('nameCategory');
        $category->IdCategory = $request->input('idCategory');
        $category->Status = $request->input('statusCategory');
        $category->save();
        return redirect('/categories');
    }

    public function edit($IdCategory){
        $categoryShow=DB::table('categories')->where('IdCategory', $IdCategory)->first();
        return view('categories.categories.updateCategory')->with('categoryShow', $categoryShow);
    }

    public function update(Request $request, $IdCategory){
        $request->validate([
            'nameCategory'=>'required'
        ]);
        $categoryUpdate=DB::table('categories')->where('idCategory', $IdCategory)
                        ->update([
                            'NameCategory'=>$request->input('nameCategory'),
                            'IdCategory'=>$request->input('idCategory'),
                            'Status'=>$request->input('statusCategory')
                        ]);
        return redirect('/categories');
    }

    public function destroy($IdCategory){
        $categoryDelete=DB::table('categories')->where('idCategory', $IdCategory)
                        ->delete();
        return redirect('/categories');
    }
}