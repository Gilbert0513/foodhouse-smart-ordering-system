<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodhouse - Order Food</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- ADD CSRF TOKEN -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        :root {
            --primary-color: #e74c3c;
            --secondary-color: #2c3e50;
            --accent-color: #f39c12;
            --light-bg: #f8f9fa;
            --dark-bg: #2c3e50;
            --success-color: #27ae60;
            --gcash-color: #0c8ce9;
            --card-color: #9b59b6;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
        }
        
        .navbar {
            background-color: var(--secondary-color) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: white !important;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0 80px;
            text-align: center;
            margin-bottom: 0;
        }
        
        .hero-section h1 {
            font-weight: 800;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        .hero-section p {
            font-size: 1.2rem;
            margin-bottom: 30px;
        }
        
        .category-nav {
            background: white;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .category-btn {
            border: none;
            background: white;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 25px;
            transition: all 0.3s;
            font-weight: 500;
            color: #555;
        }
        
        .category-btn.active, .category-btn:hover {
            background: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(231, 76, 60, 0.3);
        }
        
        .menu-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
            height: 100%;
            background: white;
        }
        
        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        }
        
        .menu-card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .menu-card:hover img {
            transform: scale(1.05);
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-title {
            font-weight: 700;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }
        
        .card-text {
            color: #777;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }
        
        .price {
            font-weight: 700;
            color: var(--primary-color);
            font-size: 1.2rem;
        }
        
        .add-to-cart {
            background-color: var(--primary-color);
            border: none;
            border-radius: 25px;
            padding: 8px 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .add-to-cart:hover {
            background-color: #c0392b;
            transform: scale(1.05);
        }
        
        .cart-sidebar {
            position: fixed;
            top: 0;
            right: -400px;
            width: 400px;
            height: 100vh;
            background: white;
            box-shadow: -5px 0 15px rgba(0,0,0,0.1);
            transition: right 0.3s;
            z-index: 1050;
        }
        
        @media (max-width: 576px) {
            .cart-sidebar {
                width: 100%;
                right: -100%;
            }
        }
        
        .cart-sidebar.open {
            right: 0;
        }
        
        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
            display: none;
        }
        
        .cart-overlay.show {
            display: block;
        }
        
        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }
        
        .cart-item:last-child {
            border-bottom: none;
        }
        
        .cart-item-name {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .cart-item-price {
            color: var(--primary-color);
            font-weight: 600;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
        }
        
        .quantity-btn {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #ddd;
            background: white;
            font-weight: bold;
        }
        
        .quantity-btn:hover {
            background: #f5f5f5;
        }
        
        .quantity-display {
            margin: 0 10px;
            font-weight: 600;
            min-width: 30px;
            text-align: center;
        }
        
        .remove-btn {
            color: #e74c3c;
            background: none;
            border: none;
            font-size: 1.2rem;
        }
        
        .order-summary {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
        
        .section-title {
            position: relative;
            margin-bottom: 30px;
            padding-bottom: 15px;
            font-weight: 700;
            color: var(--secondary-color);
        }
        
        .section-title:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 3px;
            background: var(--primary-color);
        }
        
        .search-box {
            position: relative;
        }
        
        .search-box input {
            padding-right: 50px;
            border-radius: 25px;
        }
        
        .search-box button {
            position: absolute;
            right: 5px;
            top: 5px;
            border-radius: 20px;
            background: var(--primary-color);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
        }
        
        .special-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-color);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 1;
        }
        
        .empty-cart {
            text-align: center;
            padding: 40px 20px;
            color: #777;
        }
        
        .empty-cart i {
            font-size: 4rem;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        .table-number-input {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        
        .place-order-btn {
            background: var(--success-color);
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s;
        }
        
        .place-order-btn:hover {
            background: #219653;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(39, 174, 96, 0.3);
        }
        
        .cart-count-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-color);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }
        
        .cart-btn {
            position: relative;
            background: white;
            border: none;
            border-radius: 10px;
            padding: 10px 15px;
            color: var(--secondary-color);
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .cart-btn:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 15px 25px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            z-index: 1060;
            display: none;
            animation: slideIn 0.5s ease-out;
        }
        
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        .menu-section {
            margin-bottom: 50px;
        }
        
        .recommended-badge {
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }
        
        .food-category {
            margin-bottom: 40px;
        }
        
        /* Payment Method Styles */
        .payment-methods {
            margin: 20px 0;
        }
        
        .payment-option {
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }
        
        .payment-option:hover {
            border-color: #bdbdbd;
            background-color: #f9f9f9;
        }
        
        .payment-option.selected {
            border-color: var(--primary-color);
            background-color: rgba(231, 76, 60, 0.05);
        }
        
        .payment-icon {
            font-size: 1.5rem;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }
        
        .payment-details {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }
        
        .payment-details.active {
            display: block;
        }
        
        .gcash-color {
            color: var(--gcash-color);
        }
        
        .card-color {
            color: var(--card-color);
        }
        
        .cash-color {
            color: var(--success-color);
        }
        
        .payment-form {
            margin-top: 10px;
        }
        
        .payment-form input {
            margin-bottom: 10px;
        }
        
        .qr-code {
            text-align: center;
            padding: 15px;
            background: white;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .qr-code img {
            max-width: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i>Foodhouse Restaurant
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-home me-1"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-info-circle me-1"></i> About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-phone me-1"></i> Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
                            <i class="fas fa-user me-1"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>My Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i>Order History</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="/logout">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ms-2">
                        <button class="btn cart-btn" onclick="toggleCart()">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="cart-count-badge" id="cartCount">0</span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to Foodhouse!</h1>
            <p class="lead">Experience the finest cuisine crafted with passion</p>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="search-box">
                        <input type="text" class="form-control form-control-lg" placeholder="Search for dishes...">
                        <button class="btn">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Category Navigation -->
    <section class="category-nav">
        <div class="container">
            <div class="text-center">
                <button class="category-btn active" data-category="all">All Items</button>
                <button class="category-btn" data-category="appetizers">Appetizers</button>
                <button class="category-btn" data-category="mains">Main Courses</button>
                <button class="category-btn" data-category="seafood">Seafood</button>
                <button class="category-btn" data-category="desserts">Desserts</button>
                <button class="category-btn" data-category="beverages">Beverages</button>
            </div>
        </div>
    </section>

    <!-- Menu Items -->
    <section class="py-5">
        <div class="container">
            <h2 class="section-title">Our Menu</h2>
            
            <!-- Appetizers -->
            <div class="menu-section">
                <h3 class="mb-4">Appetizers</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Spring Rolls">
                                <span class="special-badge">Chef's Special</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Crispy Spring Rolls</h5>
                                <p class="card-text">Fresh vegetables wrapped in crispy pastry, served with sweet chili sauce</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱180.00</span>
                                    <button class="btn add-to-cart" data-id="1" data-name="Crispy Spring Rolls" data-price="180.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1604503468506-a8da13d82791?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Garlic Bread">
                            <div class="card-body">
                                <h5 class="card-title">Garlic Breadsticks</h5>
                                <p class="card-text">Freshly baked breadsticks with garlic butter and herbs</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱120.00</span>
                                    <button class="btn add-to-cart" data-id="2" data-name="Garlic Breadsticks" data-price="120.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Salad">
                            <div class="card-body">
                                <h5 class="card-title">Caesar Salad</h5>
                                <p class="card-text">Fresh romaine lettuce with Caesar dressing, croutons, and parmesan</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱220.00</span>
                                    <button class="btn add-to-cart" data-id="3" data-name="Caesar Salad" data-price="220.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Main Courses -->
            <div class="menu-section">
                <h3 class="mb-4">Main Courses</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <div class="position-relative">
                                <img src="https://images.unsplash.com/photo-1606755962773-d324e74534a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Grilled Chicken">
                                <span class="recommended-badge">Recommended</span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Grilled Chicken</h5>
                                <p class="card-text">Juicy grilled chicken with special herbs and spices, served with vegetables</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱350.00</span>
                                    <button class="btn add-to-cart" data-id="4" data-name="Grilled Chicken" data-price="350.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1546833999-b9f581a1996d?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Pasta">
                            <div class="card-body">
                                <h5 class="card-title">Creamy Pasta Carbonara</h5>
                                <p class="card-text">Classic pasta with creamy sauce, bacon, and parmesan cheese</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱280.00</span>
                                    <button class="btn add-to-cart" data-id="5" data-name="Creamy Pasta Carbonara" data-price="280.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Grilled Fish">
                            <div class="card-body">
                                <h5 class="card-title">Grilled Salmon</h5>
                                <p class="card-text">Fresh salmon fillet grilled to perfection with lemon butter sauce</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱420.00</span>
                                    <button class="btn add-to-cart" data-id="6" data-name="Grilled Salmon" data-price="420.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Desserts -->
            <div class="menu-section">
                <h3 class="mb-4">Desserts</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Ice Cream">
                            <div class="card-body">
                                <h5 class="card-title">Artisanal Ice Cream</h5>
                                <p class="card-text">Homemade ice cream in vanilla, chocolate, or strawberry</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱120.00</span>
                                    <button class="btn add-to-cart" data-id="7" data-name="Artisanal Ice Cream" data-price="120.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1563729784474-d77dbb933a9e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Chocolate Cake">
                            <div class="card-body">
                                <h5 class="card-title">Chocolate Lava Cake</h5>
                                <p class="card-text">Warm chocolate cake with a molten center, served with vanilla ice cream</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱180.00</span>
                                    <button class="btn add-to-cart" data-id="8" data-name="Chocolate Lava Cake" data-price="180.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1559620192-032c4bc4674e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Cheesecake">
                            <div class="card-body">
                                <h5 class="card-title">New York Cheesecake</h5>
                                <p class="card-text">Classic creamy cheesecake with berry compote</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱200.00</span>
                                    <button class="btn add-to-cart" data-id="9" data-name="New York Cheesecake" data-price="200.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Beverages -->
            <div class="menu-section">
                <h3 class="mb-4">Beverages</h3>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1622483767028-3f66f32aef97?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Soft Drinks">
                            <div class="card-body">
                                <h5 class="card-title">Soft Drinks</h5>
                                <p class="card-text">Coke, Sprite, or Royal (500ml)</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱60.00</span>
                                    <button class="btn add-to-cart" data-id="10" data-name="Soft Drinks" data-price="60.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1439066615861-d1af74d74000?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Fresh Juice">
                            <div class="card-body">
                                <h5 class="card-title">Fresh Fruit Juice</h5>
                                <p class="card-text">Orange, Apple, or Mango (freshly squeezed)</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱90.00</span>
                                    <button class="btn add-to-cart" data-id="11" data-name="Fresh Fruit Juice" data-price="90.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mb-4">
                        <div class="card menu-card">
                            <img src="https://images.unsplash.com/photo-1511537190424-bbbab87ac5eb?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Iced Tea">
                            <div class="card-body">
                                <h5 class="card-title">House Iced Tea</h5>
                                <p class="card-text">Refreshing homemade iced tea with lemon</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price">₱70.00</span>
                                    <button class="btn add-to-cart" data-id="12" data-name="House Iced Tea" data-price="70.00">
                                        <i class="fas fa-plus"></i> Add
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Shopping Cart Sidebar -->
    <div class="cart-overlay" id="cartOverlay" onclick="toggleCart()"></div>
    <div class="cart-sidebar" id="cartSidebar">
        <div class="h-100 d-flex flex-column">
            <div class="p-3 border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart me-2"></i>Your Order
                    </h5>
                    <button type="button" class="btn-close" onclick="toggleCart()"></button>
                </div>
            </div>
            
            <div class="flex-grow-1 p-3" id="cartItems" style="overflow-y: auto;">
                <!-- Cart items will appear here -->
                <div class="empty-cart">
                    <i class="fas fa-shopping-cart"></i>
                    <h5>Your cart is empty</h5>
                    <p>Add some delicious items to get started!</p>
                </div>
            </div>
            
            <div class="p-3 border-top">
                <div class="order-summary">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="cartSubtotal">₱0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Service Charge (10%):</span>
                        <span id="serviceCharge">₱0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="cartTotal">₱0.00</strong>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Table Number</label>
                    <input type="number" class="form-control table-number-input" id="tableNumber" min="1" max="50" placeholder="Enter your table number" required>
                </div>
                
                <!-- Payment Methods -->
                <div class="payment-methods">
                    <h6 class="fw-bold mb-3">Select Payment Method</h6>
                    
                    <!-- Cash Option -->
                    <div class="payment-option" data-method="cash">
                        <div class="payment-icon cash-color">
                            <i class="fas fa-money-bill-wave"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Pay with Cash</h6>
                            <p class="mb-0 text-muted small">Pay when your order arrives</p>
                        </div>
                    </div>
                    
                    <!-- GCash Option -->
                    <div class="payment-option" data-method="gcash">
                        <div class="payment-icon gcash-color">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">GCash</h6>
                            <p class="mb-0 text-muted small">Pay using GCash mobile wallet</p>
                        </div>
                    </div>
                    
                    <!-- Card Option -->
                    <div class="payment-option" data-method="card">
                        <div class="payment-icon card-color">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <h6 class="mb-1">Credit/Debit Card</h6>
                            <p class="mb-0 text-muted small">Pay with Visa, Mastercard, or Amex</p>
                        </div>
                    </div>
                </div>
                
                <!-- Payment Details -->
                <div id="paymentDetails">
                    <!-- GCash Payment Details -->
                    <div class="payment-details" id="gcashDetails">
                        <h6 class="fw-bold">GCash Payment</h6>
                        <p class="small text-muted">Scan the QR code below to complete your payment</p>
                        
                        <div class="qr-code">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=GCashPaymentFoodhouseTable12Total500" alt="GCash QR Code">
                            <p class="small">Scan to pay with GCash</p>
                        </div>
                        
                        <div class="mt-3">
                            <p class="small"><strong>GCash Number:</strong> 0917-123-4567</p>
                            <p class="small"><strong>Account Name:</strong> Foodhouse Restaurant</p>
                        </div>
                    </div>
                    
                    <!-- Card Payment Details -->
                    <div class="payment-details" id="cardDetails">
                        <h6 class="fw-bold">Card Payment</h6>
                        <p class="small text-muted">Enter your card details securely</p>
                        
                        <div class="payment-form">
                            <div class="mb-3">
                                <label class="form-label small">Card Number</label>
                                <input type="text" class="form-control" placeholder="1234 5678 9012 3456" maxlength="19">
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label small">Expiry Date</label>
                                        <input type="text" class="form-control" placeholder="MM/YY">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label small">CVV</label>
                                        <input type="text" class="form-control" placeholder="123" maxlength="3">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label small">Cardholder Name</label>
                                <input type="text" class="form-control" placeholder="John Doe">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cash Payment Details -->
                    <div class="payment-details" id="cashDetails">
                        <h6 class="fw-bold">Cash Payment</h6>
                        <p class="small text-muted">Please have exact change ready when our staff delivers your order</p>
                        <div class="alert alert-info small">
                            <i class="fas fa-info-circle me-2"></i>
                            Our staff will provide you with change if needed
                        </div>
                    </div>
                </div>
                
                <!-- Loading Indicator -->
                <div class="loading" id="loadingIndicator">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Processing your order...</p>
                </div>
                
                <button class="btn place-order-btn w-100 mt-3" onclick="placeOrder()" id="placeOrderBtn">
                    <i class="fas fa-paper-plane me-2"></i>Place Order
                </button>
            </div>
        </div>
    </div>
    
    <!-- Notification -->
    <div class="notification" id="notification">
        <i class="fas fa-check-circle me-2"></i>
        <span id="notificationText">Item added to cart!</span>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];
        let selectedPaymentMethod = null;
        
        function toggleCart() {
            const sidebar = document.getElementById('cartSidebar');
            const overlay = document.getElementById('cartOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');
        }
        
        // Add to cart functionality
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);
                
                // Check if item already in cart
                const existingItem = cart.find(item => item.id === id);
                if (existingItem) {
                    existingItem.quantity++;
                } else {
                    cart.push({
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1
                    });
                }
                
                updateCart();
                showNotification(`${name} added to cart!`);
            });
        });
        
        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const cartSubtotal = document.getElementById('cartSubtotal');
            const serviceCharge = document.getElementById('serviceCharge');
            const cartTotal = document.getElementById('cartTotal');
            
            // Update cart count
            cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            
            // Update cart items
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="empty-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <h5>Your cart is empty</h5>
                        <p>Add some delicious items to get started!</p>
                    </div>
                `;
            } else {
                cartItems.innerHTML = cart.map(item => `
                    <div class="cart-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <div class="cart-item-name">${item.name}</div>
                                <div class="cart-item-price">₱${item.price.toFixed(2)}</div>
                            </div>
                            <div class="d-flex align-items-center">
                                <div class="quantity-controls">
                                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', -1)">-</button>
                                    <span class="quantity-display">${item.quantity}</span>
                                    <button class="quantity-btn" onclick="updateQuantity('${item.id}', 1)">+</button>
                                </div>
                                <button class="btn remove-btn ms-2" onclick="removeFromCart('${item.id}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                `).join('');
            }
            
            // Update totals
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const serviceFee = subtotal * 0.1; // 10% service charge
            const total = subtotal + serviceFee;
            
            cartSubtotal.textContent = `₱${subtotal.toFixed(2)}`;
            serviceCharge.textContent = `₱${serviceFee.toFixed(2)}`;
            cartTotal.textContent = `₱${total.toFixed(2)}`;
        }
        
        function updateQuantity(itemId, change) {
            const item = cart.find(item => item.id === itemId);
            if (item) {
                item.quantity += change;
                if (item.quantity <= 0) {
                    cart = cart.filter(i => i.id !== itemId);
                }
                updateCart();
            }
        }
        
        function removeFromCart(itemId) {
            const item = cart.find(item => item.id === itemId);
            if (item) {
                cart = cart.filter(i => i.id !== itemId);
                updateCart();
                showNotification(`${item.name} removed from cart`);
            }
        }
        
        function showNotification(message) {
            const notification = document.getElementById('notification');
            const notificationText = document.getElementById('notificationText');
            
            notificationText.textContent = message;
            notification.style.display = 'block';
            
            setTimeout(() => {
                notification.style.display = 'none';
            }, 3000);
        }
        
        // Payment Method Selection
        document.querySelectorAll('.payment-option').forEach(option => {
            option.addEventListener('click', function() {
                // Remove selected class from all options
                document.querySelectorAll('.payment-option').forEach(opt => {
                    opt.classList.remove('selected');
                });
                
                // Add selected class to clicked option
                this.classList.add('selected');
                
                // Get selected payment method
                selectedPaymentMethod = this.getAttribute('data-method');
                
                // Hide all payment details
                document.querySelectorAll('.payment-details').forEach(detail => {
                    detail.classList.remove('active');
                });
                
                // Show selected payment details
                if (selectedPaymentMethod === 'gcash') {
                    document.getElementById('gcashDetails').classList.add('active');
                } else if (selectedPaymentMethod === 'card') {
                    document.getElementById('cardDetails').classList.add('active');
                } else if (selectedPaymentMethod === 'cash') {
                    document.getElementById('cashDetails').classList.add('active');
                }
            });
        });
        
        // UPDATED: Place Order function that sends data to backend
        function placeOrder() {
            const tableNumber = document.getElementById('tableNumber').value;
            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');
            
            if (!tableNumber) {
                alert('Please enter your table number!');
                return;
            }
            
            if (cart.length === 0) {
                alert('Your cart is empty!');
                return;
            }
            
            if (!selectedPaymentMethod) {
                alert('Please select a payment method!');
                return;
            }
            
            // Show loading, hide button
            placeOrderBtn.style.display = 'none';
            loadingIndicator.style.display = 'block';
            
            // Prepare order data for backend
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const serviceFee = subtotal * 0.1;
            const total = subtotal + serviceFee;
            
            const orderData = {
                table_number: parseInt(tableNumber),
                payment_method: selectedPaymentMethod,
                items: cart.map(item => ({
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                })),
                subtotal: subtotal,
                service_charge: serviceFee,
                total: total
            };
            
            // Send order to server using Fetch API
            fetch('/customer/orders', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify(orderData)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Hide loading, show button
                placeOrderBtn.style.display = 'block';
                loadingIndicator.style.display = 'none';
                
                if (data.success) {
                    showNotification(`Order placed successfully! Order #${data.order_number}`);
                    
                    // Clear cart
                    cart = [];
                    updateCart();
                    document.getElementById('tableNumber').value = '';
                    
                    // Reset payment selection
                    document.querySelectorAll('.payment-option').forEach(opt => {
                        opt.classList.remove('selected');
                    });
                    document.querySelectorAll('.payment-details').forEach(detail => {
                        detail.classList.remove('active');
                    });
                    selectedPaymentMethod = null;
                    
                    toggleCart();
                } else {
                    alert('❌ Failed to place order. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Hide loading, show button
                placeOrderBtn.style.display = 'block';
                loadingIndicator.style.display = 'none';
                alert('❌ Error placing order. Please check your connection and try again.');
            });
        }
        
        // Category filtering
        document.querySelectorAll('.category-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Remove active class from all buttons
                document.querySelectorAll('.category-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                
                // Add active class to clicked button
                this.classList.add('active');
                
                const category = this.dataset.category;
                // Implement category filtering here
                filterMenu(category);
            });
        });
        
        function filterMenu(category) {
            const menuSections = document.querySelectorAll('.menu-section');
            
            if (category === 'all') {
                menuSections.forEach(section => {
                    section.style.display = 'block';
                });
            } else {
                menuSections.forEach(section => {
                    if (section.querySelector('h3').textContent.toLowerCase().includes(category)) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            }
            
            // Scroll to menu section
            document.querySelector('.py-5').scrollIntoView({ behavior: 'smooth' });
        }
        
        // Search functionality
        document.querySelector('.search-box input').addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('.menu-card');
            
            menuItems.forEach(item => {
                const title = item.querySelector('.card-title').textContent.toLowerCase();
                const description = item.querySelector('.card-text').textContent.toLowerCase();
                
                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    item.closest('.col-md-4').style.display = 'block';
                } else {
                    item.closest('.col-md-4').style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>