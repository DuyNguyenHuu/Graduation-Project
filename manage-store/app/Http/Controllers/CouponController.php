<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\CouponService;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;

class CouponController extends Controller
{
    protected $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    public function index(Request $request)
    {
        $getCoupon = $this->couponService->getList($request);
        return view('coupons.indexCoupon', compact('getCoupon'));
    }

    public function create()
    {
        return view('coupons.addCoupon');
    }

    public function store(StoreCouponRequest $request)
    {
        $this->couponService->create($request->validated());
        return redirect('/coupons')->with('success', 'Coupon added successfully!');
    }

    public function edit($idCoupon)
    {
        $getCoupon = $this->couponService->find($idCoupon);
        return view('coupons.updateCoupon', compact('getCoupon'));
    }

    public function update(UpdateCouponRequest $request, $idCoupon)
    {
        $this->couponService->update($idCoupon, $request->validated());
        return redirect('/coupons')->with('success', 'Coupon updated successfully!');
    }

    public function destroy($idCoupon)
    {
        $this->couponService->delete($idCoupon);
        return redirect('/coupons')->with('success', 'Coupon deleted successfully!');
    }
}