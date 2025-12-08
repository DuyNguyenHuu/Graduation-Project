<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;

class VNPayController extends Controller
{
    public function createPayment(Request $request){
        $vnp_TmnCode = config('vnpay.vnp_TmnCode');
        $vnp_HashSecret = config('vnpay.vnp_HashSecret');
        $vnp_Url = config('vnpay.vnp_Url');
        $vnp_ReturnUrl = config('vnpay.vnp_ReturnUrl');

        $vnp_TxnRef = time();
        $vnp_OrderInfo = 'Thanh toan don hang';
        $vnp_OrderType = 'billpayment';
        if(session('coupon')!=null){
            $totalVND = session('coupon')['final_total']*26360;
        }
        else{
            $totalVND = session('total')*26360;
        }
        $vnp_Amount = intval($totalVND * 100);

        $vnp_Locale = 'vn';
        $vnp_IpAddr = $request->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_ReturnUrl,
            "vnp_TxnRef" => $vnp_TxnRef
        );
        ksort($inputData);

        $hashData = "";
        $i = 0;
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $paymentUrl = $vnp_Url . "?" . http_build_query($inputData) . "&vnp_SecureHash=" . $secureHash;
        return redirect($paymentUrl);
    }

    public function returnPayment(Request $request)
    {
        if ($request->vnp_ResponseCode == "00") {
            $order = new Order();
            $order->user_id = Auth::user()->IdUser;
            $order->consignee = session('delivery_info')['fullname'];
            $order->phone = session('delivery_info')['phone'];
            $order->province = session('delivery_info')['province_name'];
            $order->ward = session('delivery_info')['ward_name'];
            $order->address = session('delivery_info')['address'];
            $order->note = session('delivery_info')['note'];
            $order->created_at = now();
            if (session('coupon') != null) {
                $order->total = session('coupon')['final_total'];
            } else {
                $order->total = session('total');
            }
            $order->save();
            foreach (session('cart') as  $item) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $item['id'];
                $orderDetail->quantity = $item['quantity'];
                $orderDetail->price = $item['price'];
                $orderDetail->save();
            }
            session()->forget('cart');
            session()->forget('coupon');
            session()->forget('delivery_info');
            return redirect('/result')->with('message', 'Payment successful!');
        } else {
            session()->forget('coupon');
            session()->forger('delivery_info');
            return redirect('/result')->with('message', 'payment failed!');
        }
    }
    public function result(){
        return view('content.result');
    }
}