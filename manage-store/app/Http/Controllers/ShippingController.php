<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GeneralInfos;
use Illuminate\Support\Facades\DB;

class ShippingController extends Controller
{
    public function index(){
        $getShipping = DB::table('generalinfo')->where('id', 1)->first();
        return view('shipping', compact('getShipping'));
    }
    public function update(Request $request){
        DB::table('generalinfo')->where('id', 1)->update([
            'Detail' => $request->shippingInfo
        ]);
        return redirect('/shippings')->with('success', 'Shipping Info updated successfully!');;
    }
}