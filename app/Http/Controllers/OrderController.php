<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Debug: Check if request is received
        \Log::info('Order request received:', $request->all());
        
        $request->validate([
            'table_number' => 'required|integer|min:1',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        try {
            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . Str::upper(Str::random(6)) . '-' . time(),
                'table_number' => $request->table_number,
                'status' => 'pending',
                'total_amount' => 0,
                'user_id' => Auth::id(),
            ]);

            $totalAmount = 0;

            // Create order items
            foreach ($request->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'item_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                $totalAmount += $item['price'] * $item['quantity'];
            }

            // Update order total
            $order->update(['total_amount' => $totalAmount]);

            \Log::info('Order created successfully:', ['order_id' => $order->id]);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
                'order_number' => $order->order_number,
            ]);

        } catch (\Exception $e) {
            \Log::error('Order creation failed:', ['error' => $e->getMessage()]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $orders = Order::with(['items', 'user'])->latest()->get();
        return view('admin.orders', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,ready,completed'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated!');
    }
}