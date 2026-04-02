<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $getCategory = Cache::remember('categories_all', 3600, function(){
            return DB::table('categories')
                    ->where('Status', '=', '1')
                    ->select('*')->get();
        });
        $category = $request->productCategory ?? 'all';
        $cacheKeyProduct = 'products_publish_' . $category;
        $getProduct = Cache::remember($cacheKeyProduct, 3600, function() use ($category){
            $query = DB::table('products')
                        ->where('StatusProduct', 'Publish')
                        ->inRandomOrder()
                        ->limit(10);
            if ($category != 'all'){
                $query->where('category', $category);
            }
            return $query->get();
        });

        $cacheKeyFrequent = 'frequent_products';
        $getFrequentProduct = Cache::remember($cacheKeyFrequent, 900, function(){
            return DB::table('orderdetails')
                    ->join('products', 'orderdetails.product_id', '=', 'products.IdProduct')
                    ->select('products.IdProduct',
                            'products.NameProduct',
                            'products.NewPrice',
                            'products.OldPrice',
                            'products.ImageURL',
                    DB::raw('SUM(orderdetails.quantity) AS total_sold'))
                    ->where('products.StatusProduct', 'Publish')
                    ->groupBy(
                        'products.IdProduct',
                        'products.NameProduct',
                        'products.NewPrice',
                        'products.OldPrice',
                        'products.ImageURL'
                    )
                    ->orderByDesc('total_sold')
                    ->limit(15)
                    ->get();
        });
        
        $userRecommendations = [];
        if (Auth::check()) {
            try {
                $userId = Auth::user()->IdUser;

                $response = Http::timeout(3)
                    ->get(env('RECOMMENDER_API').'/recommend-user/'.$userId);

                if ($response->successful()) {
                    $userRecommendations = collect(
                $response->json()['recommendations']
                )->map(function ($item) {
                    return (object) $item;
                });
                }
            } catch (\Exception $e) {
                $userRecommendations = [];
            }
        }
        $itemRecommendations = [];
        if (Auth::check()) {
            try {
                $userId = Auth::user()->IdUser;

                $response = Http::timeout(3)
                    ->get(env('RECOMMENDER_API').'/recommend-item/'.$userId);

                if ($response->successful()) {
                    $itemRecommendations = collect(
                $response->json()['recommendations']
                )->map(function ($item) {
                    return (object) $item;
                });
                }
            } catch (\Exception $e) {
                $itemRecommendations = [];
            }
        }
        return view('content.home',compact('getCategory', 'getProduct', 'getFrequentProduct', 'userRecommendations', 'itemRecommendations'));
    }
}