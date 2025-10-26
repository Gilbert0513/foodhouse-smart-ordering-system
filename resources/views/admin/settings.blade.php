@extends('layouts.admin')

@section('title', 'System Settings')

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5>General Settings</h5>
            </div>
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label class="form-label">Restaurant Name</label>
                        <input type="text" class="form-control" value="Foodhouse Restaurant">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" value="admin@foodhouse.com">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="tel" class="form-control" value="+63 912 345 6789">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea class="form-control">Himamaylan City, Negros Occidental</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header">
                <h5>System Information</h5>
            </div>
            <div class="card-body">
                <p><strong>PHP Version:</strong> {{ phpversion() }}</p>
                <p><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                <p><strong>Server Time:</strong> {{ now()->format('Y-m-d H:i:s') }}</p>
                <p><strong>Timezone:</strong> {{ config('app.timezone') }}</p>
                <p><strong>Database:</strong> MySQL</p>
                <p><strong>Environment:</strong> {{ app()->environment() }}</p>
                
                <div class="mt-4">
                    <h6>Quick Actions</h6>
                    <button class="btn btn-outline-danger btn-sm">Clear Cache</button>
                    <button class="btn btn-outline-warning btn-sm">Backup Database</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection