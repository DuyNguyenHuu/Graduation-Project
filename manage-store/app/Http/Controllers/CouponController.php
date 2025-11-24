<?php

namespace App\Http\Controllers;

use App\Models\Coupons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponController extends Controller
{
    public function index(Request $request){
        $query = DB::table('coupons');

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('Title', 'like', '%' . $request->search . '%')
                ->orWhere('Code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->discount_type) {
            $query->where('DiscountType', $request->discount_type);
        }

        if ($request->status) {
            $query->where('StatusCoupon', $request->status);
        }

        if ($request->start_date){
            $query->where('StartDate', '>=', $request->start_date);
        }
        if ($request->end_date){
            $query->where('EndDate', '<=', $request->end_date);
        }

        $getCoupon = $query->paginate(10)->appends($request->all());

        return view('coupons.indexCoupon', compact('getCoupon'));
    }

    public function create(){
        return view('coupons.addCoupon');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required',
            'code' => 'required|min:6|unique:coupons,Code'
        ]);

        $coupon = new Coupons();
        $coupon->Title = $request->input('title');
        $coupon->Code = $request->input('code');
        $coupon->ConditionCoupon = $request->input('condition');
        $coupon->DiscountType = $request->input('discounttype');
        $coupon->DiscountValue = $request->input('discountvalue');
        $coupon->StartDate = $request->input('startdate');
        $coupon->EndDate = $request->input('enddate');
        $coupon->Time = $request->input('time');
        $coupon->StatusCoupon = $request->input('status');
        $coupon->save();
        return redirect('/coupons')->with('success', 'Coupon added successfully!');
    }

    public function edit($idCoupon){
        $getCoupon = DB::table('coupons')->where('IdCoupon', $idCoupon)->first();
        return view('coupons.updateCoupon', compact('getCoupon'));
    }

    public function update(Request $request, $idCoupon){
        $request->validate([
            'title' => 'required',
            'code' => 'required|min:6'
        ]);

        DB::table('coupons')->where('IdCoupon', $idCoupon)->update([
            'Title' => $request->input('title'),
            'Code' => $request->input('code'),
            'ConditionCoupon' => $request->input('condition'),
            'DiscountType' => $request->input('discounttype'),
            'DiscountValue' => $request->input('discountvalue'),
            'StartDate' => $request->input('startdate'),
            'EndDate' => $request->input('enddate'),
            'Time' => $request->input('time'),
            'StatusCoupon' => $request->input('status')
        ]);
        return redirect('/coupons')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($idCoupon){
        DB::table('coupons')->where('IdCoupon', $idCoupon)->delete();
        return redirect('/coupons')->with('success', 'Coupon deleted successfully!');
    }
}