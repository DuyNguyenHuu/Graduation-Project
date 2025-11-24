<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartsController extends Controller
{
    public function index(){
        $cart=session()->get('cart',[]);
        return view('content.carts', compact('cart'));
    }

    public function addToCart(Request $request){
        $product=DB::table('products')->where('IdProduct', $request->product_id)->first();
        $option_size=DB::table('options')
                ->where('IdProduct_Option', $request->product_id)
                ->where('IdOption', $request->optionSize)
                ->first();
        $option_type=DB::table('options')
                ->where('IdProduct_Option', $request->product_id)
                ->where('IdOption', $request->optionType)
                ->first();
        $final_price=$product->NewPrice;
        if($option_size != null){
            $final_price = $final_price + $option_size->BonusPrice;
        }
        if($option_type != null){
            $final_price = $final_price + $option_type->BonusPrice;
        }

        $cart=session()->get('cart',[]);

        $cartKey = $product->IdProduct . '_' . ($request->optionSize ?? "Default") . '_' . ($request->optionType ?? "Default");
        if(array_key_exists($cartKey, $cart)) {
            $cart[$cartKey]['quantity'] += $request->product_quantity ?? 1;
        } else {
            $cart[$cartKey] = [
                "id" => $product->IdProduct,
                "name" => $product->NameProduct,
                "price" => $final_price,
                "type" => $option_type ? $option_type->SubOption : "Default",
                "size" => $option_size ? $option_size->SubOption : "Default",
                "quantity" => $request->product_quantity ?? 1,
                "image" => $product->ImageURL
            ];
        }
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function remove($key){
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            unset($cart[$key]);
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Đã xoá sản phẩm khỏi giỏ hàng');
    }

    public function increase($key){
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            $cart[$key]['quantity'] += 1;
        }

        session()->put('cart', $cart);
        return back();
    }

    public function decrease($key){
        $cart = session()->get('cart', []);

        if (isset($cart[$key])) {
            if ($cart[$key]['quantity'] > 1) {
                $cart[$key]['quantity'] -= 1;
            } else {
                // Nếu quantity = 1 và nhấn -, tự động xoá sp
                unset($cart[$key]);
            }
        }

        session()->put('cart', $cart);
        return back();
    }

    public function applyCoupon(Request $request){
        $code=$request->coupon_code;
        $coupon=DB::table('coupons')
                ->where('Code', $code)
                ->where('StatusCoupon', 1)
                ->first();
        if(!$coupon){
            return back()->with('coupon_error', 'Coupon not found!');
        }
        $today = now()->toDateString();
        if($today<$coupon->StartDate || $today>$coupon->EndDate){
            return back()->with('coupon_error', 'Coupon expired!');
        }
        if($coupon->Time==0 && $coupon->Time != null){
            return back()->with('coupon_error', 'Coupon expired!');
        }
        if($request->total<$coupon->ConditionCoupon){
            return back()->with('coupon_error', 'Total is not enough for this coupon!');
        }
        $cart = session()->get('cart', []);

        if (!$cart) {
            return back()->with('coupon_error', 'Cart is empty!');
        }
        if($coupon->DiscountType==1){
            $final_total=$request->total*(100-$coupon->DiscountValue)/100;
            $discount=$request->total-$final_total;
        }
        if($coupon->DiscountType==2){
            $final_total=$request->total-$coupon->DiscountValue;
            $discount=$coupon->DiscountValue;
        }
        session()->put('coupon', [
            'Title'=> $coupon->Title,
            'code' => $coupon->Code,
            'discount' => $discount,
            'final_total' => $final_total
        ]);
        return back()->with('coupon_success', $coupon->Code.' applied successfully!');
    }
}