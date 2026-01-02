<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\Options;
use Mews\Purifier\Facades\Purifier;

class ProductListController extends Controller
{
    public function index(request $request){
        $filterType     = $request->input('filterType');
        $filterStatus   = $request->input('filterStatus');
        $filterCategory = $request->input('filterCategory');
        $filterSub      = $request->input('filterSub');
        $filterName     = $request->input('filterName');
        $productList=DB::table('products')
                        ->when($filterType, function ($query, $filterType) {
                            return $query->where('TypeProduct', $filterType);
                        })
                        ->when($filterStatus, function ($query, $filterStatus) {
                            return $query->where('StatusProduct', $filterStatus);
                        })
                        ->when($filterCategory, function ($query, $filterCategory) {
                            return $query->where('Category', $filterCategory);
                        })
                        ->when($filterSub, function ($query, $filterSub) {
                            return $query->where('SubCategory', $filterSub);
                        })
                        ->when($filterName, function ($query, $filterName) {
                            return $query->where('NameProduct', 'like', '%' . $filterName . '%');
                        })
                        ->orderBy('updated_at', 'desc')
                        ->select('*')->paginate(10)->appends($request->query());
        $categoryList=DB::table('categories')->select('*')->get();
        $subCategoryList=DB::table('subcategories')
                        ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                        ->select('*')
                        ->get();
        return view('productList.indexProductList', compact('productList', 'categoryList', 'subCategoryList'));
    }

    public function create(){
        $categoryList=DB::table('categories')->select('*')->get();
        $subCategoryList=DB::table('subcategories')
                        ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                        ->select('*')
                        ->get();
        return view('productList.addProductList', compact('categoryList','subCategoryList'));
    }

    public function store(request $request){
        $request->validate([
            'nameProduct'=>'required',
            'idProduct'=>'required',
            'newPriceProduct'=>'required',
            'oldPriceProduct'=>'required',
        ]);

        $cleanHtml = Purifier::clean($request->descriptionProduct);

        $product = new Products();
        $product->IdProduct=$request->input('idProduct');
        $product->NameProduct=$request->input('nameProduct');
        $product->TypeProduct=$request->input('typeProduct');
        $product->NewPrice=$request->input('newPriceProduct');
        $product->OldPrice=$request->input('oldPriceProduct');
        $product->StatusProduct=$request->input('statusProduct');
        $product->Tag=$request->tags;
        $product->ImageURL=$request->input('imageURLProduct');
        $product->Category=$request->input('categoryProduct');
        $product->SubCategory=$request->input('subCategoryProduct');
        $product->Description=$cleanHtml;
        $product->save();
        return redirect('productList')->with('success', 'Product added successfully!');

    }

    public function edit($IdProduct){
        $productDescription = DB::table('products')
            ->where('IdProduct', $IdProduct)
            ->first();

        // Nếu KHÔNG có category → không thể join → để null
        if (!$productDescription->Category) {
            $productCategory = null;

        // Nếu có category nhưng KHÔNG có subcategory
        } elseif ($productDescription->Category && !$productDescription->SubCategory) {

            $productCategory = DB::table('categories')
                ->where('IdCategory', $productDescription->Category)
                ->select(
                    'categories.IdCategory',
                    'categories.NameCategory'
                )
                ->first();

            // Thêm giá trị IdSub = null để Blade không bị lỗi
            if ($productCategory) {
                $productCategory->IdSub = null;
            }

        // Nếu có cả category + subcategory
        } else {

            $productCategory = DB::table('subcategories')
                ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                ->where('subcategories.IdSub', $productDescription->SubCategory)
                ->select(
                    'categories.IdCategory',
                    'subcategories.IdSub'
                )
                ->first();
        }

        // Lấy list
        $categoryList = DB::table('categories')->get();

        $subCategoryList = DB::table('subcategories')
            ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
            ->select(
                'subcategories.IdSub',
                'subcategories.IdSubCategory',
                'subcategories.Name'
            )
            ->get();

        return view('productList.updateProductList', compact(
            'productDescription',
            'productCategory',
            'categoryList',
            'subCategoryList'
        ));
    }


    public function update(request $request, $IdProduct){
        $request->validate([
            'nameProduct'=>'required',
            'idProduct'=>'required',
            'newPriceProduct'=>'required',
            'oldPriceProduct'=>'required',
        ]);

        $cleanHtml = Purifier::clean($request->descriptionProduct);
        $productUpdate=DB::table('products')->where('products.IdProduct', $IdProduct)
                        ->update([
                            'IdProduct'=>$request->input('idProduct'),
                            'NameProduct'=>$request->input('nameProduct'),
                            'TypeProduct'=>$request->input('typeProduct'),
                            'NewPrice'=>$request->input('newPriceProduct'),
                            'OldPrice'=>$request->input('oldPriceProduct'),
                            'StatusProduct'=>$request->input('statusProduct'),
                            'ImageURL'=>$request->input('imageURLProduct'),
                            'Tag'=>$request->input('tags'),
                            'Category'=>$request->input('categoryProduct'),
                            'SubCategory'=>$request->input('subCategoryProduct'),
                            'Description'=>$cleanHtml
                        ]);
        return redirect('/productList')->with('success', 'Product updated successfully!');
    }

    public function destroy($IdProduct){
        $productDelete=DB::table('products')->where('IdProduct', $IdProduct)
                        ->delete();
        return redirect('/productList');
    }

    public function attribute($productList){
        $optionProduct=DB::table('options')
                        ->join('products', 'products.IdProduct', '=', 'options.IdProduct_Option')
                        ->where('products.IdProduct', $productList)
                        ->orderBy('OptionProduct', 'asc')
                        ->select('*')
                        ->get();
        return view('productList.indexAttribute', compact('optionProduct', 'productList'));
    }

    public function createAttribute($productList){
        return view('productList.addAttribute', compact('productList'));
    }

    public function storeAttribute(Request $request, $productList){
        $request->validate([
            'subOptionProduct'=>'required',
            'quantityProduct'=>'required',
            'priceProduct'=>'required',
        ]);

        $option = new Options();
        $option->OptionProduct=$request->input('optionProduct');
        $option->SubOption=$request->input('subOptionProduct');
        $option->IdProduct_Option=$productList;
        $option->Quantity=$request->input('quantityProduct');
        $option->BonusPrice=$request->input('priceProduct');
        $option->save();
        return redirect()->route('productList.attribute', ['productList' => $productList])->with('success', 'Attribute added successfully!');
    }

    public function editAttribute($productList,$idOption){
        $optionEdit=DB::table('options')->where('options.IdOption', $idOption)
                                        ->where('options.IdProduct_Option', $productList)
                                        ->first();
        return view('productList.updateAttribute', compact('optionEdit','productList', 'idOption'));
    }

    public function updateAttribute(Request $request, $productList, $idOption){
        $request->validate([
            'subOptionProduct'=>'required',
            'quantityProduct'=>'required',
            'priceProduct'=>'required',
        ]);

        $productUpdate=DB::table('options')
                        ->where('options.IdProduct_Option', $productList)
                        ->where('options.IdOption', $idOption)
                        ->update([
                            'OptionProduct'=>$request->input('optionProduct'),
                            'SubOption'=>$request->input('subOptionProduct'),
                            'Quantity'=>$request->input('quantityProduct'),
                            'BonusPrice'=>$request->input('priceProduct'),
                        ]);
        return redirect()->route('productList.attribute', ['productList' => $productList]);

    }

    public function destroyAttribute($productList, $idOption){
        DB::table('options')
            ->where('IdProduct_Option', $productList)
            ->where('IdOption', $idOption)
            ->delete();

        return redirect()
            ->route('productList.attribute', ['productList' => $productList])
            ->with('success', 'Attribute deleted successfully!');
    }
}