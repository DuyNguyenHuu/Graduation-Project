<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\SubCategories;

class SubCategoryController extends Controller
{
    public function index(){
        $subCategoryList=DB::table('subcategories')
                        ->join('categories','subcategories.IdSubCategory','=', 'categories.IdCategory')
                        ->orderBy('IdCategory', 'asc')
                        ->select('*')->get();
        return view('categories.subcategories.indexSubCategory', compact('subCategoryList'));
    }

    public function create(){
        $categoryList=DB::table('categories')->select('*')->get();
        return view('categories.subcategories.addSubCategory', compact('categoryList'));
    }

    public function store(request $request){
        $request->validate([
            'nameSubCategory'=>'required',
            'idSubCategory'=>'required'
        ]);

        $subCategory = new SubCategories();
        $subCategory->IdSub = $request->input('idSubCategory');
        $subCategory->Name = $request->input('nameSubCategory');
        $subCategory->IdSubCategory = $request->input('idCategory');
        $subCategory->StatusSub = $request->input('statusSub');
        $subCategory->save();
        return redirect('/subcategories');
    }

    public function edit(Request $request, $IdSub){
        $subCategoryShow=DB::table('subcategories')
                        ->join('categories','subcategories.IdSubCategory','=','categories.IdCategory')
                        ->where('IdSub',$IdSub)
                        ->where('IdSubCategory', $request->input('hiddenIdCategory'))
                        ->first();
        $categoryList=DB::table('categories')->select('*')->get();
        return view('categories.subcategories.updateSubCategory', compact('categoryList', 'subCategoryShow'));
    }

    public function update(request $request, $IdSub){
        $request->validate([
            'nameCategory'=>'required',
            'idSubCategory'=>'required'
        ]);
        $subCategoryUpdate=DB::table('subcategories')
                        ->where('IdSub', $IdSub)
                        ->Where('IdSubCategory', $request->input('hiddenCategory'))
                        ->update([
                            'IdSub'=>$request->input('idSubCategory'),
                            'Name'=>$request->input('nameSubCategory'),
                            'IdSubCategory'=>$request->input('nameCategory'),
                            'StatusSub'=>$request->input('statusSubCategory')
                        ]);
        return redirect('/subcategories');
    }

    public function destroy(Request $request, $IdSub){
        $subCategoryDelete=DB::table('subcategories')->where('idSub', $IdSub)
                                                            ->where('idSubCategory', $request->input('idCategory'))
                        ->delete();
        return redirect('/subcategories');
    }
}