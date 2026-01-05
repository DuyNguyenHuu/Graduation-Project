<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductReviewService
{
    public function getList(Request $request)
    {
        $query = DB::table('reviews')
            ->join('users', 'users.IdUser', '=', 'reviews.IdUser')
            ->join('products', 'products.IdProduct', '=', 'reviews.IdProduct_Review')
            ->select(
                'products.NameProduct',
                'users.Name',
                'reviews.*'
            )
            ->orderByDesc('reviews.created_at');

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('users.Name', 'like', "%{$keyword}%")
                  ->orWhere('products.NameProduct', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('evaluate')) {
            $query->where('reviews.Evaluate', $request->evaluate);
        }

        if ($request->filled('status')) {
            $query->where('reviews.Status', $request->status);
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function getDetail($IdReview)
    {
        return DB::table('reviews')
            ->join('users', 'users.IdUser', '=', 'reviews.IdUser')
            ->join('products', 'products.IdProduct', '=', 'reviews.IdProduct_Review')
            ->where('reviews.IdReview', $IdReview)
            ->select(
                'users.*',
                'reviews.Comments',
                'reviews.Evaluate',
                'reviews.Status',
                'reviews.IdReview'
            )
            ->first();
    }

    public function updateStatus($IdReview, $status)
    {
        return DB::table('reviews')
            ->where('IdReview', $IdReview)
            ->update([
                'Status' => $status,
                'updated_at' => now(),
            ]);
    }

    public function delete($IdReview)
    {
        return DB::table('reviews')
            ->where('IdReview', $IdReview)
            ->delete();
    }
}