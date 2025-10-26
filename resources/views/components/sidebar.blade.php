<!-- Sidebar Component -->
<nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
    <div class="position-sticky pt-3">
        <div class="sidebar-sticky">
            <!-- Brand -->
            <div class="text-center p-3 border-bottom">
                <h4 class="text-white">🍽️ Foodhouse</h4>
                <small class="text-muted">Admin Panel</small>
            </div>

            <!-- Navigation Menu -->
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin') || request()->is('/') ? 'active' : '' }}" href="/admin">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="/admin/users">
                        <i class="fas fa-users"></i>
                        Manage Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/inventory*') ? 'active' : '' }}" href="/admin/inventory">
                        <i class="fas fa-box"></i>
                        Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}" href="/admin/orders">
                        <i class="fas fa-shopping-cart"></i>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/reports*') ? 'active' : '' }}" href="/admin/reports">
                        <i class="fas fa-chart-bar"></i>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="/admin/settings">
                        <i class="fas fa-cog"></i>
                        Settings
                    </a>
                </li>
            </ul>

            <!-- System Info -->
            <div class="p-3 border-top">
                <small class="text-muted">System Status</small>
                <div class="text-success">
                    <i class="fas fa-circle"></i> Online
                </div>
                <small class="text-muted">Last login: {{ \Carbon\Carbon::now()->format('M j, Y g:i A') }}</small>
            </div>
        </div>
    </div>
</nav>