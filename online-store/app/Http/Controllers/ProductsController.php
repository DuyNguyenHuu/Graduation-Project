<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function Laravel\Prompts\select;

class ProductsController extends Controller
{
    public function index(Request $request){
        $getCategory=DB::table('categories')
                    ->where('Status', '=', '1')
                    ->select('*')
                    ->get();
        $getSubCategory=DB::table('subcategories')
                    ->where('StatusSub', '=', '1')
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
            $getProduct=$getFilterProduct->orderBy('created_at', 'desc')
                        ->paginate(10)->appends($request->all());
        }
        else{
            $getProduct=DB::table('products')->where('StatusProduct', '=', 'Publish')->orderBy('created_at', 'desc')
                            ->select('*')->paginate(10)->appends($request->all());
        }
        return view('content.products',compact('getCategory','getProduct', 'getSubCategory'));
    }

    public function searchAjax(Request $request)
    {
        $search = $request->search;

        $products = DB::table('products')
            ->where('StatusProduct', 'Publish')
            ->where('NameProduct', 'LIKE', "%$search%")
            ->select('IdProduct','NameProduct','ImageURL')
            ->limit(5)
            ->get();

        return response()->json($products);
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
                        ->where('reviews.Status', '=', 1)
                        ->join('users', 'reviews.IdUser', '=', 'users.IdUser')
                        ->orderBy('reviews.created_at', 'desc')
                        ->get(['reviews.*', 'users.Name']);
        $avgRating=round($reviewProduct->avg('Evaluate'), 1);
        $starCount = [
            5 => $reviewProduct->where('Evaluate', 5)->count(),
            4 => $reviewProduct->where('Evaluate', 4)->count(),
            3 => $reviewProduct->where('Evaluate', 3)->count(),
            2 => $reviewProduct->where('Evaluate', 2)->count(),
            1 => $reviewProduct->where('Evaluate', 1)->count()
        ];
        $getShipping = DB::table('generalinfo')->where('id', 1)->first();
        $recommendedProducts = [];
        try{
            $response = http::timeout(3)->get(env('RECOMMENDER_API').'/recommend/'.$IdProduct);
            if ($response->successful()) {
            $recommendedProducts = collect(
                $response->json()['recommendations']
            )->map(function ($item) {
                return (object) $item;
            });
        }
            
        }catch(\Exception $e){
            $recommendedProducts = [];
        }
        return view('content.detailProduct', compact('DetailProduct', 'getSubCategory', 'getCategory', 'optionProduct', 'reviewProduct', 'avgRating', 'starCount', 'getShipping', 'recommendedProducts'));
    }

    public function submitReview(Request $request, $idProduct){

        DB::table('reviews')->insert([
            'IdProduct_Review' => $idProduct,
            'IdUser' => auth()->user()->IdUser,
            'Evaluate' => $request->input('evaluate'),
            'Comments' => $request->input('comment'),
            'created_at' => now(),
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'Your review has been submitted! Please wait for admin approval.');
    }
}