<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    public function index(Request $request){
        $query = DB::table('orders')->where('user_id',Auth::user()->IdUser)
                    ->join('users', 'orders.user_id', '=', 'users.IdUser')
                    ->orderBy('created_at','desc')
                    ->select('orders.*', 'users.Name as name');
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('users.Name', 'like', '%' . $request->search . '%')
                ->orWhere('consignee', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('orders.status', $request->status);
        }

        if ($request->date){
            $query->where('orders.created_at', '>=', $request->date);
        }

        $getOrders = $query->paginate(10)->appends($request->all());
        return view('content.orders', compact('getOrders'));
    }

    public function detailOrder($idOrder){
        $detailOrder = DB::table('orderdetails')
                        ->where('orderdetails.order_id', $idOrder)
                        ->join('products','orderdetails.product_id','=','products.IdProduct')
                        ->select('orderdetails.*', 'products.NameProduct as product_name', 'products.ImageURL as product_image')
                        ->get();
        return view('content.orderdetails', compact('detailOrder'));
    }
}