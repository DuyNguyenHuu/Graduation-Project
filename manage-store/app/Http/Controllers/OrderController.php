<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.IdUser')
                    ->orderBy('created_at','desc')
                    ->select('orders.*', 'users.Name as name');
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('users.Name', 'like', '%' . $request->search . '%')
                ->orWhere('consignee', 'like', '%' . $request->search . '%')
                ->orwhere('id', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('orders.status', $request->status);
        }

        if ($request->date){
            $query->where('orders.created_at', '=', $request->date);
        }

        $getOrder = $query->paginate(10)->appends($request->all());
        return view('orders.indexOrder', compact('getOrder'));
    }

    public function edit($idOrder){
        $getOrderById = DB::table('orderdetails')
                        ->where('orderdetails.order_id', $idOrder)
                        ->join('products','orderdetails.product_id','=','products.IdProduct')
                        ->select('orderdetails.*', 'products.NameProduct as product_name', 'products.ImageURL as product_image')
                        ->get();
        $orderId = DB::table('orders')->where('id', $idOrder)->first();
        return view('orders.updateOrder', compact('getOrderById', 'orderId'));
    }

    public function update(Request $request, $idOrder){
        DB::table('orders')->where('id', $idOrder)->update([
            'status' => $request->status,
            'updated_at' => now()
        ]);
        $order = DB::table('orders')
                    ->where('orders.id', $idOrder)
                    ->join('users', 'orders.user_id', '=', 'users.IdUser')
                    ->select('orders.*', 'users.Name as Name', 'users.email as Email')
                    ->first();
        Mail::to($order->Email)->send(new OrderStatusUpdated($order));
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }
}