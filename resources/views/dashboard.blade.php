@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Orders</h5>
                        <h2>{{ $totalOrders }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-list-alt fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Pending Orders</h5>
                        <h2>{{ $pendingOrders }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Low Stock Items</h5>
                        <h2>{{ $lowStockItems }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Recent Orders</h5>
            </div>
            <div class="card-body">
                @foreach($recentOrders as $order)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>#{{ $order->order_number }}</strong>
                        <br>
                        <small>Table {{ $order->table_number }} • {{ $order->user->name }}</small>
                    </div>
                    <span class="badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Low Stock Alerts</h5>
            </div>
            <div class="card-body">
                @foreach($lowStockInventory as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $item->name }}</strong>
                        <br>
                        <small>Stock: {{ $item->quantity }} {{ $item->unit }}</small>
                    </div>
                    <span class="badge bg-danger">Low Stock</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection