<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

class ProductsController extends Controller
{
    public function index(Request $request){
        $getCategory=DB::table('categories')
                    ->select('*')
                    ->get();
        $getSubCategory=DB::table('subcategories')
                    ->select('*')
                    ->get();
        $filters = $request->input('filter',[]);
        if(!empty($filters)){
            $getFilterProduct=DB::table('products')->where('StatusProduct', '=', 'Publish')
                                ->select('*')->whereRaw('1=0');
            foreach($filters as $filter){
                $filterParts=explode(',', $filter);
                $IdCategory=$filterParts[0];
                $IdSubCategory=isset($filterParts[1])?$filterParts[1]:null;
                if($IdSubCategory==null){
                    $allFilterProduct=DB::table('products')->where('StatusProduct', '=', 'Publish')
                                        ->where('category', '=', $IdCategory)->select('*');
                    $getFilterProduct=$getFilterProduct->union($allFilterProduct);
                }
                else{
                    $filterProduct=DB::table('products')->where([['category', '=', $IdCategory], ['SubCategory', '=', $IdSubCategory]])->select('*');
                    $getFilterProduct=$getFilterProduct->union($filterProduct);
                }
            }
            $getProduct=$getFilterProduct->paginate(10)->appends($request->all());
        }
        else{
            $getProduct=DB::table('products')->where('StatusProduct', '=', 'Publish')
                            ->select('*')->paginate(10)->appends($request->all());
        }
        return view('content.products',compact('getCategory','getProduct', 'getSubCategory'));
    }

    public function detailProduct($IdProduct){
        $getSubCategory=DB::table('subcategories')
                    ->join('categories', 'subcategories.IdSubCategory', '=', 'categories.IdCategory')
                    ->select('*')
                    ->get();
        $getCategory=DB::table('categories')
                    ->select('*')
                    ->get();
        $DetailProduct=DB::table('products')->where('IdProduct', $IdProduct)
                        ->first();
        $optionProduct=DB::table('options')->where('IdProduct_Option', $IdProduct)
                        ->get();
        $reviewProduct=DB::table('reviews')->where('IdProduct_Review', $IdProduct)
                        ->join('users', 'reviews.IdUser', '=', 'users.IdUser')
                        ->get(['reviews.*', 'users.Name']);
        return view('content.detailProduct', compact('DetailProduct', 'getSubCategory', 'getCategory', 'optionProduct', 'reviewProduct'));
    }

    public function submitReview(Request $request, $idProduct){

        DB::table('reviews')->insert([
            'IdProduct_Review' => $idProduct,
            'IdUser' => auth()->user()->IdUser,
            'Evaluate' => $request->input('evaluate'),
            'Comments' => $request->input('comment'),
            'created_at' => now(),
            'status' => 0
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted! Please wait for admin approval.');
    }
}