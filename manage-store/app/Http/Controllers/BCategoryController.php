<?php

namespace App\Http\Controllers;

use App\Http\Services\BCategoryService;
use App\Http\Requests\StoreBCategoryRequest;
use App\Http\Requests\UpdateBCategoryRequest;

class BCategoryController extends Controller
{
    protected $bCategoryService;
    public function __construct(BCategoryService $bCategoryService){
        $this->bCategoryService = $bCategoryService;
    }

    public function index(){
        $bCategoryList = $this->bCategoryService->getAll();
        return view('blogs.bcategories.indexBCategory', compact('bCategoryList'));
    }

    public function create(){
        return view('blogs.bcategories.addBCategory');
    }

    public function store(StoreBCategoryRequest $request){
        $this->bCategoryService->create($request->validated());
        return redirect('/bcategories')->with('success', 'BCategory created successfully.');
    }

    public function edit($idBCategory){
        $bCategoryShow = $this->bCategoryService->findById($idBCategory);
        return view('blogs.bcategories.updateBCategory')->with('bCategoryShow', $bCategoryShow);
    }

    public function update(UpdateBCategoryRequest $request, $idBCategory){
        $this->bCategoryService->update($idBCategory, $request->validated());
        return redirect('/bcategories')->with('success', 'BCategory updated successfully.');
    }

    public function destroy($idBCategory){
        $this->bCategoryService->delete($idBCategory);
        return redirect('/bcategories')->with('success', 'BCategory deleted successfully.');
    }
}