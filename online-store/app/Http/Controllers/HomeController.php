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
        return view('content.home',compact('getCategory', 'getProduct')); // view này sẽ kế thừa layout app.blade.php
    }
}