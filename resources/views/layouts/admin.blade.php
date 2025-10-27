<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Foodhouse Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        .sidebar {
            min-height: 100vh;
            background: #2c3e50;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            z-index: 1000;
            transition: all 0.3s;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            border-bottom: 1px solid #34495e;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: #34495e;
            color: #fff;
            padding-left: 25px;
        }
        .sidebar .nav-link.active {
            background: #3498db;
            color: white;
            border-left: 4px solid #2980b9;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
            min-height: 100vh;
            background: #f8f9fa;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 999;
        }
        .card { 
            transition: transform 0.2s; 
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card:hover { 
            transform: translateY(-2px); 
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-preparing { background-color: #cce7ff; color: #004085; }
        .status-ready { background-color: #d1edff; color: #0c5460; }
        .status-completed { background-color: #d4edda; color: #155724; }
        
        /* Mobile responsive */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }
            .sidebar.show {
                left: 0;
            }
            .main-content {
                margin-left: 0;
            }
            .sidebar-overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
            }
            .sidebar-overlay.show {
                display: block;
            }
        }
        
        /* Sidebar brand styling */
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid #34495e;
            background: #34495e;
        }
        .sidebar-brand h5 {
            color: #ecf0f1;
            margin: 0;
            font-weight: 600;
        }
        .sidebar-brand .text-muted {
            color: #bdc3c7 !important;
            font-size: 0.8rem;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="container-fluid">
        <div class="row">
            <!-- Include Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                <!-- Top Navigation Bar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" onclick="toggleSidebar()">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav me-auto">
                                <li class="nav-item">
                                    <span class="navbar-text">
                                        <i class="fas fa-user me-2"></i>Welcome, {{ auth()->user()->name }}
                                    </span>
                                </li>
                            </ul>
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link position-relative" href="#">
                                        <i class="fas fa-bell"></i>
                                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                            3
                                        </span>
                                    </a>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-user-circle me-2"></i>{{ auth()->user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="/logout" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Page Title -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 fw-bold text-dark">@yield('title')</h1>
                        @hasSection('action_button')
                            @yield('action_button')
                        @endif
                    </div>

                    <!-- Main Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle function
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        // Close sidebar when clicking on overlay
        document.getElementById('sidebarOverlay').addEventListener('click', function() {
            toggleSidebar();
        });

        // Close sidebar when clicking on a link (mobile)
        document.querySelectorAll('.sidebar .nav-link').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 768) {
                    toggleSidebar();
                }
            });
        });

        // Auto-close sidebar on window resize
        window.addEventListener('resize', function() {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (window.innerWidth >= 768) {
                sidebar.classList.remove('show');
                overlay.classList.remove('show');
            }
        });
    </script>
    @yield('scripts')
</body>
</html>