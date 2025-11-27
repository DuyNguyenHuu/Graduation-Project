<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(){
        return view('content.checkout');
    }

    public function checkout(Request $request){
        $request->validate([
            'fullname'=>'required|max:255|min:2',
            'phone' => ['required', 'regex:/^(0[3|5|7|8|9])[0-9]{8}$/'],
            'address'=>'required|max:255',
            'note'=>'max:255',
        ]);
        session()->put('delivery_info', [
            'fullname'=>$request->fullname,
            'phone'=>$request->phone,
            'province'=>$request->province,
            'province_name'=>$request->province_name,
            'ward'=>$request->ward,
            'ward_name'=>$request->ward_name,
            'address'=>$request->address,
            'note'=>$request->note
        ]);
        return redirect()->route('checkout.invoice');
    }
    public function invoice(){
        return view('content.invoice');
    }
}