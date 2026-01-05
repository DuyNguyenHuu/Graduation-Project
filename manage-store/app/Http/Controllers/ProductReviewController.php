<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductReviewRequest;
use App\Services\ProductReviewService;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    protected $productReviewService;

    public function __construct(ProductReviewService $productReviewService)
    {
        $this->productReviewService = $productReviewService;
    }

    public function index(Request $request)
    {
        $productReview = $this->productReviewService->getList($request);
        return view('productReview.indexProductReview', compact('productReview'));
    }

    public function edit($IdReview)
    {
        $detailProductReview = $this->productReviewService->getDetail($IdReview);
        return view('productReview.detailProductReview', compact('detailProductReview'));
    }

    public function update(UpdateProductReviewRequest $request, $IdReview)
    {
        $this->productReviewService->updateStatus(
            $IdReview,
            $request->validated()['statusProductReview']
        );

        return redirect('/productReviews')->with('success', 'Review updated successfully!');
    }

    public function destroy($IdReview)
    {
        $this->productReviewService->delete($IdReview);
        return redirect('/productReviews')->with('success', 'Review has been deleted.');
    }
}