@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalUsers }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Inventory Items</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalInventory }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Total Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalOrders }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-shopping-cart fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Today's Sales</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₱{{ number_format($todaySales, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alerts -->
@if($lowStockItems > 0)
<div class="alert alert-warning d-flex align-items-center" role="alert">
    <i class="fas fa-exclamation-triangle me-2"></i>
    <div>
        You have <strong>{{ $lowStockItems }}</strong> items with low stock that need attention!
    </div>
</div>
@endif

<div class="row">
    <!-- Recent Orders -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-clock me-2"></i>Recent Orders
                </h6>
                <a href="/admin/orders" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="card-body">
                @foreach($recentOrders as $order)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>#{{ $order->order_number }}</strong>
                        <br>
                        <small class="text-muted">Table {{ $order->table_number }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                        <br>
                        <small class="text-muted">₱{{ number_format($order->total_amount, 2) }}</small>
                    </div>
                </div>
                @endforeach
                
                @if($recentOrders->isEmpty())
                <p class="text-muted text-center py-3">No recent orders</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Low Stock Alerts -->
    <div class="col-xl-6 col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-danger">
                    <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Alerts
                </h6>
                <span class="badge bg-danger">{{ $lowStockItems }}</span>
            </div>
            <div class="card-body">
                @foreach($lowStockInventory as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $item->name }}</strong>
                        <br>
                        <small class="text-muted">
                            Current: {{ $item->quantity }} {{ $item->unit }} | 
                            Min: {{ $item->min_stock_level }}
                        </small>
                    </div>
                    <span class="badge bg-danger">Low Stock</span>
                </div>
                @endforeach
                
                @if($lowStockInventory->isEmpty())
                <p class="text-success text-center py-3">
                    <i class="fas fa-check-circle me-2"></i>All items are well stocked
                </p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-bolt me-2"></i>Quick Actions
                </h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3 mb-3">
                        <a href="/admin/orders/create" class="btn btn-outline-primary btn-lg w-100">
                            <i class="fas fa-plus fa-2x mb-2"></i><br>
                            New Order
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/admin/inventory" class="btn btn-outline-success btn-lg w-100">
                            <i class="fas fa-box fa-2x mb-2"></i><br>
                            Manage Inventory
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/admin/reports" class="btn btn-outline-warning btn-lg w-100">
                            <i class="fas fa-chart-bar fa-2x mb-2"></i><br>
                            View Reports
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="/admin/settings" class="btn btn-outline-info btn-lg w-100">
                            <i class="fas fa-cog fa-2x mb-2"></i><br>
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection