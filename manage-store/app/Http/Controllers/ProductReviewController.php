<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewController extends Controller
{
    public function index(Request $request){
        $query = DB::table('reviews')
                ->join('users', 'users.IdUser', '=', 'reviews.IdUser')
                ->join('products', 'products.IdProduct', '=', 'reviews.IdProduct_Review')
                ->select('products.NameProduct', 'users.Name', 'reviews.*')
                ->orderByDesc('reviews.created_at');
        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('users.Name', 'like', "%{$keyword}%")
                ->orWhere('products.NameProduct', 'like', "%{$keyword}%");
            });
        }
        if ($request->filled('evaluate')) {
            $query->where('reviews.Evaluate', '=', $request->evaluate);
        }
            if ($request->filled('status')) {
            $query->where('reviews.Status', '=', $request->status);
        }
        $productReview = $query->paginate(10);
        $productReview->appends($request->all());
        return view('productReview.indexProductReview', compact('productReview'));
    }

    public function edit($IdReview){
        $detailProductReview = DB::table('reviews')
                                ->where('reviews.IdReview', $IdReview)
                                ->join('users', 'users.IdUser', '=', 'reviews.IdUser')
                                ->join('products', 'products.IdProduct', '=', 'reviews.IdProduct_Review')
                                ->select('users.*', 'reviews.Comments', 'reviews.Evaluate', 'reviews.Status', 'reviews.IdReview')
                                ->get();
        return view('productReview.detailProductReview', compact('detailProductReview'));
    }

    public function update(Request $request, $IdReview){
        DB::table('reviews')->where('IdReview', $IdReview)
                        ->update([
                            'Status'=>$request->input('statusProductReview')
                        ]);
        return redirect('/productReviews');
    }
    public function destroy($IdReview)
    {
        DB::table('reviews')->where('IdReview', $IdReview)->delete();

        return redirect('/productReviews')->with('success', 'Review has been deleted.');
    }
}