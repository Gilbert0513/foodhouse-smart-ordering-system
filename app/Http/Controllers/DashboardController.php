<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get real data from database
        $totalUsers = User::count();
        $totalInventory = Inventory::count();
        $totalOrders = Order::count();
        
        // Low stock items
        $lowStockItems = Inventory::where('quantity', '<=', DB::raw('min_stock_level'))->count();
        
        // Today's sales
        $todaySales = Order::whereDate('created_at', today())
                          ->where('status', 'completed')
                          ->sum('total_amount');
        
        // Recent orders - FIXED: use 'user' relationship
        $recentOrders = Order::with('user')
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Low stock inventory
        $lowStockInventory = Inventory::where('quantity', '<=', DB::raw('min_stock_level'))
                                     ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalInventory', 
            'totalOrders',
            'lowStockItems',
            'todaySales',
            'recentOrders',
            'lowStockInventory'
        ));
    }
}