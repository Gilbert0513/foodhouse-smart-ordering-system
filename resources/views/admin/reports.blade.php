@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('content')
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Sales</h5>
                <h2>₱{{ number_format($totalSales, 2) }}</h2>
                <p class="mb-0">All time sales</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Today's Revenue</h5>
                <h2>₱{{ number_format($todayRevenue, 2) }}</h2>
                <p class="mb-0">{{ $todayOrders }} orders today</p>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5 class="card-title">Monthly Revenue</h5>
                <h2>₱{{ number_format($monthlyRevenue, 2) }}</h2>
                <p class="mb-0">{{ $monthlyOrders }} orders this month</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
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
        <div class="card shadow">
            <div class="card-header">
                <h5>Recent Activities</h5>
            </div>
            <div class="card-body">
                <div class="border-bottom py-2">
                    <small class="text-muted">Today, 10:30 AM</small>
                    <p class="mb-1">New order #ORD-005 created</p>
                </div>
                <div class="border-bottom py-2">
                    <small class="text-muted">Today, 09:15 AM</small>
                    <p class="mb-1">Inventory item "Chicken" updated</p>
                </div>
                <div class="border-bottom py-2">
                    <small class="text-muted">Yesterday, 05:20 PM</small>
                    <p class="mb-1">User "John Doe" registered</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection