@extends('layouts.app')

@section('title', 'Reports & Analytics')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Today's Sales</h5>
                <h2>₱{{ number_format($dailySales->total_sales ?? 0, 2) }}</h2>
                <p class="mb-0">{{ $dailySales->total_orders ?? 0 }} Orders</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5>Top Selling Items</h5>
            </div>
            <div class="card-body">
                @foreach($topSelling as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $item->name }}</strong>
                    </div>
                    <span class="badge bg-primary">{{ $item->total_sold }} sold</span>
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
                @foreach($lowStock as $item)
                <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                    <div>
                        <strong>{{ $item->name }}</strong>
                        <br>
                        <small>Current: {{ $item->quantity }} | Min: {{ $item->min_stock_level }}</small>
                    </div>
                    <span class="badge bg-danger">Alert</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection