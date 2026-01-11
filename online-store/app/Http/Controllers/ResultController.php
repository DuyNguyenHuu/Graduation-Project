<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function result(){
        $order = new Order();
        $order->user_id = Auth::user()->IdUser;
        $order->consignee = session('delivery_info')['fullname'];
        $order->phone = session('delivery_info')['phone'];
        $order->province = session('delivery_info')['province_name'];
        $order->ward = session('delivery_info')['ward_name'];
        $order->address = session('delivery_info')['address'];
        $order->note = session('delivery_info')['note'];
        $order->method = session('payment_method');
        $order->created_at = now();
        if (session('coupon') != null) {
            $order->total = session('coupon')['final_total'];
        } else {
            $order->total = session('total');
        }
        $order->save();
        session()->put('payment_method', 'cod');
        foreach (session('cart') as  $item) {
            $orderDetail = new OrderDetail();
            $orderDetail->order_id = $order->id;
            $orderDetail->product_id = $item['id'];
            $orderDetail->quantity = $item['quantity'];
            $orderDetail->price = $item['price'];
            $orderDetail->size = $item['size'];
            $orderDetail->type = $item['type'];
            $orderDetail->save();
        }
        session()->forget('cart');
        session()->forget('coupon');
        session()->forget('delivery_info');
        return view('content.result')->with('message', 'Place order successful!');
    }
}