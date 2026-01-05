<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $getOrder = $this->orderService->getList($request);
        return view('orders.indexOrder', compact('getOrder'));
    }

    public function edit($idOrder)
    {
        $getOrderById = $this->orderService->getOrderDetail($idOrder);
        $orderId = $this->orderService->getOrderInfo($idOrder);

        return view('orders.updateOrder', compact('getOrderById', 'orderId'));
    }

    public function update(UpdateOrderRequest $request, $idOrder)
    {
        $this->orderService->updateStatus($idOrder, $request->status);

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order status updated successfully.');
    }
}