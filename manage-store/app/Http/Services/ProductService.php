<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\DB;
use App\Models\Products;
use App\Models\Options;
use Mews\Purifier\Facades\Purifier;

class ProductService
{
    public function getProductList($request)
    {
        return DB::table('products')
            ->when($request->filterType, fn($q) => $q->where('TypeProduct', $request->filterType))
            ->when($request->filterStatus, fn($q) => $q->where('StatusProduct', $request->filterStatus))
            ->when($request->filterCategory, fn($q) => $q->where('Category', $request->filterCategory))
            ->when($request->filterSub, fn($q) => $q->where('SubCategory', $request->filterSub))
            ->when($request->filterName, fn($q) =>
                $q->where('NameProduct', 'like', '%' . $request->filterName . '%')
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(10)
            ->appends($request->query());
    }

    public function createProduct($request)
    {
        $cleanHtml = Purifier::clean($request->descriptionProduct);

        $product = new Products();
        $product->IdProduct     = $request->idProduct;
        $product->NameProduct   = $request->nameProduct;
        $product->TypeProduct   = $request->typeProduct;
        $product->NewPrice      = $request->newPriceProduct;
        $product->OldPrice      = $request->oldPriceProduct;
        $product->StatusProduct = $request->statusProduct;
        $product->Tag           = $request->tags;
        $product->ImageURL      = $request->imageURLProduct;
        $product->Category      = $request->categoryProduct;
        $product->SubCategory   = $request->subCategoryProduct;
        $product->Description   = $cleanHtml;
        $product->save();
    }

    public function getEditData($IdProduct)
    {
        $productDescription = DB::table('products')
            ->where('IdProduct', $IdProduct)
            ->first();

        // Không có category
        if (!$productDescription->Category) {
            $productCategory = null;

        // Có category nhưng không có sub
        } elseif ($productDescription->Category && !$productDescription->SubCategory) {

            $productCategory = DB::table('categories')
                ->where('IdCategory', $productDescription->Category)
                ->select(
                    'categories.IdCategory',
                    'categories.NameCategory'
                )
                ->first();

            if ($productCategory) {
                $productCategory->IdSub = null;
            }

        // Có đủ category + sub
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

        return [
            'productDescription' => $productDescription,
            'productCategory'    => $productCategory,
            'categoryList'       => DB::table('categories')->get(),
            'subCategoryList'    => DB::table('subcategories')
                ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                ->select(
                    'subcategories.IdSub',
                    'subcategories.IdSubCategory',
                    'subcategories.Name'
                )
                ->get(),
        ];
    }

    public function updateProduct($IdProduct, $request)
    {
        $cleanHtml = Purifier::clean($request->descriptionProduct);

        DB::table('products')
            ->where('IdProduct', $IdProduct)
            ->update([
                'IdProduct'     => $request->idProduct,
                'NameProduct'   => $request->nameProduct,
                'TypeProduct'   => $request->typeProduct,
                'NewPrice'      => $request->newPriceProduct,
                'OldPrice'      => $request->oldPriceProduct,
                'StatusProduct' => $request->statusProduct,
                'ImageURL'      => $request->imageURLProduct,
                'Tag'           => $request->tags,
                'Category'      => $request->categoryProduct,
                'SubCategory'   => $request->subCategoryProduct,
                'Description'   => $cleanHtml
            ]);
    }

    public function deleteProduct($IdProduct)
    {
        DB::table('products')->where('IdProduct', $IdProduct)->delete();
    }

    public function getAttributes($productId)
    {
        return DB::table('options')
            ->where('IdProduct_Option', $productId)
            ->orderBy('OptionProduct')
            ->get();
    }

    public function storeAttribute($productList, $data)
    {
        DB::table('options')->insert([
        'OptionProduct'     => $data['optionProduct'],
        'SubOption'         => $data['subOptionProduct'],
        'IdProduct_Option'  => $productList,
        'Quantity'          => (int) $data['quantityProduct'],
        'BonusPrice'        => (float) $data['priceProduct'],
        'created_at'        => now(),
        'updated_at'        => now(),
    ]);

    }

    public function updateAttribute($productList, $idOption, $request)
    {
        DB::table('options')
            ->where('IdProduct_Option', $productList)
            ->where('IdOption', $idOption)
            ->update([
                'OptionProduct' => $request->optionProduct,
                'SubOption'     => $request->subOptionProduct,
                'Quantity'      => $request->quantityProduct,
                'BonusPrice'    => $request->priceProduct,
            ]);
    }

    public function deleteAttribute($productList, $idOption)
    {
        DB::table('options')
            ->where('IdProduct_Option', $productList)
            ->where('IdOption', $idOption)
            ->delete();
    }
}