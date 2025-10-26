<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Login Routes
Route::get('/login', function () {
    if (Auth::check()) {
        return redirect('/admin');
    }
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (Auth::attempt($request->only('email', 'password'))) {
        $request->session()->regenerate();
        return redirect('/admin');
    }

    return back()->withErrors([
        'email' => 'Wrong email or password!',
    ]);
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
});

// Admin Routes
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/admin', [DashboardController::class, 'index']);
    Route::get('/', function () { return redirect('/admin'); });
    
    // Users
    Route::get('/admin/users', function() {
        $users = \App\Models\User::all();
        return view('admin.users', compact('users'));
    });
    
    // Inventory
    Route::get('/admin/inventory', function() {
        $inventory = \App\Models\Inventory::all();
        return view('admin.inventory', compact('inventory'));
    });
    
    // Orders
    Route::get('/admin/orders', function() {
        $orders = \App\Models\Order::all();
        return view('admin.orders', compact('orders'));
    });
    
    // Reports
   // Reports - using controller
Route::get('/admin/reports', [ReportController::class, 'index']);

    
    // Settings
    Route::get('/admin/settings', function() {
        return view('admin.settings');
    });
});

// Emergency login route
Route::get('/fix-login', function() {
    \App\Models\User::truncate();
    
    $admin = new \App\Models\User();
    $admin->name = 'Admin';
    $admin->email = 'admin@foodhouse.com';
    $admin->password = \Illuminate\Support\Facades\Hash::make('admin123');
    $admin->role = 'admin';
    $admin->save();
    
    \Illuminate\Support\Facades\Auth::login($admin);
    
    return redirect('/admin')->with('success', 'User created and logged in!');
});