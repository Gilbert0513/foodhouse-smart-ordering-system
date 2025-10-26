@extends('layouts.app')

@section('title', 'Orders Management')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h3>Orders Management</h3>
    <a href="{{ route('orders.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>Create New Order
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Table</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>{{ $order->table_number }}</td>
                        <td>
                            <span class="badge status-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->user->name }}</td>
                        <td>
                            <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                                @csrf
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="preparing" {{ $order->status == 'preparing' ? 'selected' : '' }}>Preparing</option>
                                    <option value="ready" {{ $order->status == 'ready' ? 'selected' : '' }}>Ready</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection