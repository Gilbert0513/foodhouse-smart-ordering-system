<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Sales data
        $totalSales = Order::sum('total_amount');
        $todayRevenue = Order::whereDate('created_at', today())->sum('total_amount');
        $todayOrders = Order::whereDate('created_at', today())->count();
        $monthlyRevenue = Order::whereMonth('created_at', now()->month)->sum('total_amount');
        $monthlyOrders = Order::whereMonth('created_at', now()->month)->count();
        
        // Top selling items (dummy data muna)
        $topSelling = [
            (object)['name' => 'Chicken', 'total_sold' => 45],
            (object)['name' => 'Rice', 'total_sold' => 38],
            (object)['name' => 'Coke', 'total_sold' => 25],
            (object)['name' => 'Pork', 'total_sold' => 20],
            (object)['name' => 'Fish', 'total_sold' => 15],
        ];

        return view('admin.reports', compact(
            'totalSales', 'todayRevenue', 'todayOrders', 
            'monthlyRevenue', 'monthlyOrders', 'topSelling'
        ));
    }
}