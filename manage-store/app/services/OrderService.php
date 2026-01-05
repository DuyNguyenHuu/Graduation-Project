<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderService
{
    public function getList($request)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.IdUser')
            ->orderBy('orders.created_at', 'desc')
            ->select('orders.*', 'users.Name as name');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('users.Name', 'like', '%' . $request->search . '%')
                  ->orWhere('orders.consignee', 'like', '%' . $request->search . '%')
                  ->orWhere('orders.id', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('orders.status', $request->status);
        }

        if ($request->filled('date')) {
            $query->whereDate('orders.created_at', $request->date);
        }

        return $query->paginate(10)->appends($request->all());
    }

    public function getOrderDetail($idOrder)
    {
        return DB::table('orderdetails')
            ->join('products', 'orderdetails.product_id', '=', 'products.IdProduct')
            ->where('orderdetails.order_id', $idOrder)
            ->select(
                'orderdetails.*',
                'products.NameProduct as product_name',
                'products.ImageURL as product_image'
            )
            ->get();
    }

    public function getOrderInfo($idOrder)
    {
        return DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.IdUser')
            ->where('orders.id', $idOrder)
            ->select(
                'orders.*',
                'users.Name as Name',
                'users.Email as Email'
            )
            ->first();
    }

    public function updateStatus($idOrder, $status)
    {
        DB::table('orders')
            ->where('id', $idOrder)
            ->update([
                'status' => $status,
                'updated_at' => now()
            ]);

        $order = $this->getOrderInfo($idOrder);

        Mail::to($order->Email)->send(new OrderStatusUpdated($order));
    }
}