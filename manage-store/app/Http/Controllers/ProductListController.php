<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ProductService;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;

class ProductListController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $productList = $this->productService->getProductList($request);
        $categoryList = DB::table('categories')->get();
        $subCategoryList = DB::table('subcategories')->get();

        return view('productList.indexProductList', compact(
            'productList', 'categoryList', 'subCategoryList'
        ));
    }

    public function create(){
        $categoryList=DB::table('categories')->select('*')->get();
        $subCategoryList=DB::table('subcategories')
                        ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                        ->select('*')
                        ->get();
        return view('productList.addProductList', compact('categoryList','subCategoryList'));
    }
    
    public function store(StoreProductRequest $request)
    {
        $this->productService->createProduct($request);
        return redirect('productList')->with('success', 'Product added successfully!');
    }

    public function edit($IdProduct)
    {
        $data = $this->productService->getEditData($IdProduct);

        return view('productList.updateProductList', [
            'productDescription' => $data['productDescription'],
            'productCategory'    => $data['productCategory'],
            'categoryList'       => $data['categoryList'],
            'subCategoryList'    => $data['subCategoryList'],
        ]);
    }

    public function update(UpdateProductRequest $request, $IdProduct)
    {
        $this->productService->updateProduct($IdProduct, $request);
        return redirect('/productList')->with('success', 'Product updated successfully!');
    }

    public function destroy($IdProduct)
    {
        $this->productService->deleteProduct($IdProduct);
        return redirect('/productList');
    }


    public function attribute($productList)
    {
        $optionProduct = $this->productService->getAttributes($productList);
        return view('productList.indexAttribute', compact('optionProduct', 'productList'));
    }

    public function createAttribute($productList){
        return view('productList.addAttribute', compact('productList'));
    }

    public function storeAttribute(StoreOptionRequest $request, $productList)
    {
        $this->productService->storeAttribute($productList, $request->validated());
        return redirect()->route('productList.attribute', ['productList' => $productList])->with('success', 'Attribute added successfully!');
    }

    public function editAttribute($productList,$idOption){
        $optionEdit=DB::table('options')->where('options.IdOption', $idOption)
                                        ->where('options.IdProduct_Option', $productList)
                                        ->first();
        return view('productList.updateAttribute', compact('optionEdit','productList', 'idOption'));
    }

    public function updateAttribute(UpdateOptionRequest $request, $productList, $idOption)
    {
        $this->productService->updateAttribute($productList, $idOption, $request);
        return redirect()->route('productList.attribute', $productList)->with('success', 'Attribute updated successfully!');
    }

    public function destroyAttribute($productList, $idOption)
    {
        $this->productService->deleteAttribute($productList, $idOption);
        return redirect()->route('productList.attribute', $productList);
    }
}