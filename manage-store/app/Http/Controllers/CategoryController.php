<?php

namespace App\Http\Controllers;

use App\Http\Services\CategoryService;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categoryList = $this->categoryService->getAll();
        return view('categories.categories.indexCategory', compact('categoryList'));
    }

    public function create()
    {
        return view('categories.categories.addCategory');
    }

    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->create($request->validated());
        return redirect('/categories')->with('success', 'Category created successfully.');
    }

    public function edit($IdCategory)
    {
        $categoryShow = $this->categoryService->findByIdCategory($IdCategory);
        return view('categories.categories.updateCategory', compact('categoryShow'));
    }

    public function update(UpdateCategoryRequest $request, $IdCategory)
    {
        $this->categoryService->update($IdCategory, $request->validated());
        return redirect('/categories')->with('success', 'Category updated successfully.');
    }

    public function destroy($IdCategory)
    {
        $this->categoryService->delete($IdCategory);
        return redirect('/categories')->with('success', 'Category deleted successfully.');
    }
}