<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponsController extends Controller
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
        $query->orderByRaw("
            CASE
                WHEN Time = 0 THEN 1
                WHEN NOW() < StartDate THEN 1
                WHEN NOW() > EndDate THEN 1
                ELSE 0
            END ASC
        ");
        $getCoupon = $query->where('StatusCoupon', '=', '1')
                    ->orderBy('EndDate', 'asc')
                    ->orderBy('Time', 'desc')
                    ->paginate(10)->appends($request->all());

        return view('content.coupons', compact('getCoupon'));
    }
}