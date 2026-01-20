<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashBoardController extends Controller
{
    public function index(){
        $countOrderToday = DB::table('orders')
            ->whereDate('created_at', Carbon::today())
            ->count();
        $countOrderYesterday = DB::table('orders')
            ->whereDate('created_at', Carbon::yesterday())
            ->count();
        $percentChangeOrders = 0;
        if ($countOrderYesterday > 0) {
            $percentChangeOrders = (($countOrderToday - $countOrderYesterday) / $countOrderYesterday) * 100;
        }

        $countPendingOrders = DB::table('orders')
            ->where('status', '=', '1')
            ->count();
        $countProcessingOrders = DB::table('orders')
            ->where('status', '=', '2')
            ->count();
        $countShippedOrders = DB::table('orders')
            ->where('status', '=', '3')
            ->count();
        $countDeliveredOrders = DB::table('orders')
            ->where('status', '=', '4')
            ->count();

        $now = Carbon::now();
        $today = now()->toDateString();
        $yesterday = Carbon::yesterday();
        $currentRevenue = DB::table('orders')
            ->where('status', '=', '4')
            ->where('updated_at', '=', $today)
            ->sum('total');
        $yesterdayRevenue = DB::table('orders')
            ->where('status', '=', '4')
            ->where('updated_at', '=', $yesterday)
            ->sum('total');
        $percentChange = 0;
        if ($yesterdayRevenue > 0) {
            $percentChange = (($currentRevenue - $yesterdayRevenue) / $yesterdayRevenue) * 100;
        }

        $currentRevenueMonth = DB::table('orders')
            ->where('status', '=', '4')
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total');
        $lastRevenueMonth = DB::table('orders')
            ->where('status', '=', '4')
            ->whereMonth('updated_at', $now->subMonth()->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total');
        $percentChangeMonth = 0;
        if ($lastRevenueMonth > 0) {
            $percentChangeMonth = (($currentRevenueMonth - $lastRevenueMonth) / $lastRevenueMonth) * 100;
        }

        $revenues = DB::table('orders')
                    ->selectRaw('DATE(updated_at) as date, SUM(total) as revenue')
                    ->where('status', '4')
                    ->whereDate('updated_at', '>=', Carbon::now()->subDays(13))
                    ->groupBy('date')
                    ->orderBy('date')
                    ->get();
        $dates = collect();
        for ($i = 13; $i >= 0; $i--) {
            $dates->push(now()->subDays($i)->toDateString());
        }

        $revenuesByDate = $revenues->pluck('revenue', 'date');

        $finalData = $dates->map(function ($date) use ($revenuesByDate) {
            return [
                'date' => $date,
                'revenue' => $revenuesByDate[$date] ?? 0
            ];
        });

        return view('dashBoard', compact('countPendingOrders', 'countProcessingOrders', 'countShippedOrders', 'countDeliveredOrders',
                                                                'currentRevenue', 'percentChange','currentRevenueMonth', 'percentChangeMonth',
                                                                'countOrderToday', 'percentChangeOrders',
                                                                'finalData'));
    }
}