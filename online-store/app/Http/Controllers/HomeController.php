<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $getCategory=DB::table('categories')->select('*')->get();
        $query = DB::table('products')
                    ->where('StatusProduct', '=', 'Publish')
                    ->inRandomOrder()
                    ->limit(10);
        if ($request->has('productCategory') && $request->productCategory != '') {
            $query->where('category', $request->productCategory);
        }
        $getProduct = $query->get();
        $getFrequentProduct = DB::table('orderdetails')
                            ->join('products', 'orderdetails.product_id', '=', 'products.IdProduct')
                            ->select(
                                'products.IdProduct',
                                'products.NameProduct',
                                'products.NewPrice',
                                'products.OldPrice',
                                'products.ImageURL',
                                DB::raw('SUM(orderdetails.quantity) AS total_sold')
                            )
                            ->where('products.StatusProduct', 'Publish')
                            ->groupBy(
                                'products.IdProduct',
                                'products.NameProduct',
                                'products.NewPrice',
                                'products.OldPrice',
                                'products.ImageURL'
                            )
                            ->orderByDesc('total_sold')
                            ->limit(10)
                            ->get();
        return view('content.home',compact('getCategory', 'getProduct', 'getFrequentProduct'));
    }
}