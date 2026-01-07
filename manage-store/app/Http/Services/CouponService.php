<?php
namespace App\Http\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CouponService
{
    public function getList(Request $request)
    {
        $query = DB::table('coupons');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('Title', 'like', '%' . $request->search . '%')
                  ->orWhere('Code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('discount_type')) {
            $query->where('DiscountType', $request->discount_type);
        }

        if ($request->filled('status')) {
            $query->where('StatusCoupon', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('StartDate', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('EndDate', '<=', $request->end_date);
        }

        return $query->orderByDesc('IdCoupon')
                     ->paginate(10)
                     ->appends($request->all());
    }

    public function create(array $data)
    {
        return DB::table('coupons')->insert([
            'Title'            => $data['title'],
            'Code'             => $data['code'],
            'ConditionCoupon'  => $data['condition'] ?? null,
            'DiscountType'     => $data['discounttype'],
            'DiscountValue'    => $data['discountvalue'],
            'StartDate'        => $data['startdate'],
            'EndDate'          => $data['enddate'],
            'Time'             => $data['time'],
            'StatusCoupon'     => $data['status'],
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    public function update($idCoupon, array $data)
    {
        return DB::table('coupons')
            ->where('IdCoupon', $idCoupon)
            ->update([
                'Title'            => $data['title'],
                'Code'             => $data['code'],
                'ConditionCoupon'  => $data['condition'],
                'DiscountType'     => $data['discounttype'],
                'DiscountValue'    => $data['discountvalue'],
                'StartDate'        => $data['startdate'],
                'EndDate'          => $data['enddate'],
                'Time'             => $data['time'],
                'StatusCoupon'     => $data['status'],
                'updated_at'       => now(),
            ]);
    }

    public function delete($idCoupon)
    {
        return DB::table('coupons')
            ->where('IdCoupon', $idCoupon)
            ->delete();
    }

    public function find($idCoupon)
    {
        return DB::table('coupons')
            ->where('IdCoupon', $idCoupon)
            ->first();
    }
}