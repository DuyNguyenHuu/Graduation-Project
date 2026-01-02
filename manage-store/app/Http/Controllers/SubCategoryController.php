<?php

namespace App\Http\Controllers;

use App\Services\SubCategoryService;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    protected $subCategoryService;

    public function __construct(SubCategoryService $subCategoryService)
    {
        $this->subCategoryService = $subCategoryService;
    }

    public function index()
    {
        $subCategoryList = $this->subCategoryService->getAll();
        return view('categories.subcategories.indexSubCategory', compact('subCategoryList'));
    }

    public function create()
    {
        $categoryList = $this->subCategoryService->getCategories();
        return view('categories.subcategories.addSubCategory', compact('categoryList'));
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $this->subCategoryService->create($request->validated());
        return redirect('/subcategories')->with('success', 'SubCategory created successfully.');
    }

    public function edit(Request $request, $IdSub)
    {
        $subCategoryShow = $this->subCategoryService->find(
            $IdSub,
            $request->hiddenIdCategory
        );

        $categoryList = $this->subCategoryService->getCategories();

        return view(
            'categories.subcategories.updateSubCategory',
            compact('subCategoryShow', 'categoryList')
        );
    }

    public function update(UpdateSubCategoryRequest $request, $IdSub)
    {
        $this->subCategoryService->update(
            $IdSub,
            $request->hiddenCategory,
            $request->validated()
        );

        return redirect('/subcategories')->with('success', 'SubCategory updated successfully.');
    }

    public function destroy(Request $request, $IdSub)
    {
        $this->subCategoryService->delete(
            $IdSub,
            $request->idCategory
        );

        return redirect('/subcategories')->with('success', 'SubCategory deleted successfully.');
    }
}