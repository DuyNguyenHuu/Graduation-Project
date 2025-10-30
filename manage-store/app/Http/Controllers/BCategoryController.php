<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BCategories;
use Illuminate\Support\Facades\DB;

class BCategoryController extends Controller
{
    public function index(){
        $bCategoryList=DB::table('bcategories')->select('*')->get();
        return view('blogs.bcategories.indexBCategory', compact('bCategoryList'));
    }
    public function create(){
        return view('blogs.bcategories.addBCategory');
    }
    public function store(Request $request){
        $request->validate([
            'nameBCategory'=>'required',
            'idBCategory'=>'required'
        ]);

        $bCategory = new BCategories();
        $bCategory->BCategory = $request->input('nameBCategory');
        $bCategory->IdBCategory = $request->input('idBCategory');
        $bCategory->StatusBCategory = $request->input('statusBCategory');
        $bCategory->save();
        return redirect('/bcategories');
    }
    public function edit($idBCategory){
        $bCategoryShow=DB::table('bcategories')->where('IdBCategory', $idBCategory)->first();
        return view('blogs.bcategories.updateBCategory')->with('bCategoryShow', $bCategoryShow);
    }
    public function update(Request $request, $idBCategory){
        $request->validate([
            'nameBCategory'=>'required',
            'idBCategory'=>'required'
        ]);
        $bCategoryUpdate=DB::table('bcategories')->where('idBCategory', $idBCategory)
                        ->update([
                            'BCategory'=>$request->input('nameBCategory'),
                            'IdBCategory'=>$request->input('idBCategory'),
                            'StatusBCategory'=>$request->input('statusBCategory')
                        ]);
        return redirect('/bcategories');
    }
    public function destroy($idBCategory){
        $bCategoryDelete=DB::table('bcategories')->where('idBCategory', $idBCategory)
                        ->delete();
        return redirect('/bcategories');
    }
}