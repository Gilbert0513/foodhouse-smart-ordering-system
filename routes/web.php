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
        // Redirect based on user role
        $user = Auth::user();
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect('/admin');
        } else {
            return redirect('/customer/home');
        }
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
        
        // Redirect based on user role
        $user = Auth::user();
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect('/admin');
        } else {
            return redirect('/customer/home');
        }
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
    
    // Orders - USING CONTROLLER NOW
    Route::get('/admin/orders', [OrderController::class, 'index']);
    Route::post('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Reports
    Route::get('/admin/reports', [ReportController::class, 'index']);
    
    // Settings
    Route::get('/admin/settings', function() {
        return view('admin.settings');
    });
});

// Customer Routes
Route::middleware('auth')->group(function () {
    Route::get('/customer/home', function() {
        return view('customer.home');
    });
    
    // CUSTOMER ORDER ROUTE - ADD THIS!
    Route::post('/customer/orders', [OrderController::class, 'store']);
    
    Route::get('/', function () { 
        // Redirect to appropriate home based on role
        $user = Auth::user();
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect('/admin');
        } else {
            return redirect('/customer/home');
        }
    });
});

// Emergency login routes
Route::get('/fix-login', function() {
    \App\Models\User::truncate();
    
    // Create admin user
    $admin = new \App\Models\User();
    $admin->name = 'Admin';
    $admin->email = 'admin@foodhouse.com';
    $admin->password = \Illuminate\Support\Facades\Hash::make('admin123');
    $admin->role = 'admin';
    $admin->save();
    
    // Create customer user
    $customer = new \App\Models\User();
    $customer->name = 'John Customer';
    $customer->email = 'customer@foodhouse.com';
    $customer->password = \Illuminate\Support\Facades\Hash::make('customer123');
    $customer->role = 'customer';
    $customer->save();
    
    \Illuminate\Support\Facades\Auth::login($admin);
    
    return redirect('/admin')->with('success', 'Users created and logged in as Admin!');
});

Route::get('/login-as-customer', function() {
    $customer = \App\Models\User::where('email', 'customer@foodhouse.com')->first();
    if ($customer) {
        \Illuminate\Support\Facades\Auth::login($customer);
        return redirect('/customer/home')->with('success', 'Logged in as Customer!');
    }
    return redirect('/fix-login');
});