<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $inventory = Inventory::latest()->get();
        return view('inventory.index', compact('inventory'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category' => 'required|string',
            'unit' => 'required|string'
        ]);

        Inventory::create($request->all());

        return back()->with('success', 'Inventory item added successfully!');
    }

    public function update(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'min_stock_level' => 'required|integer|min:0',
            'category' => 'required|string',
            'unit' => 'required|string'
        ]);

        $inventory->update($request->all());

        return back()->with('success', 'Inventory item updated successfully!');
    }

    public function destroy(Inventory $inventory)
    {
        $inventory->delete();
        return back()->with('success', 'Inventory item deleted successfully!');
    }
}