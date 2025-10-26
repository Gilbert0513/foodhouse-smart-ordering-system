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
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .menu-card {
            transition: transform 0.3s, box-shadow 0.3s;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .menu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .category-nav {
            background: #f8f9fa;
            padding: 20px 0;
        }
        .category-btn {
            border: none;
            background: white;
            padding: 10px 20px;
            margin: 0 5px;
            border-radius: 25px;
            transition: all 0.3s;
        }
        .category-btn.active, .category-btn:hover {
            background: #007bff;
            color: white;
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
        .loading {
            display: none;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-utensils me-2"></i>Foodhouse Restaurant
            </a>
            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
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
                </div>
                <button class="btn btn-warning ms-2" onclick="toggleCart()">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="badge bg-danger" id="cartCount">0</span>
                </button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold">Welcome to Foodhouse!</h1>
            <p class="lead">Delicious food delivered to your table</p>
            <div class="row justify-content-center mt-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" placeholder="Search for dishes...">
                        <button class="btn btn-primary btn-lg">
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
            <div class="text-center mb-4">
                <h3>Our Menu</h3>
                <p class="text-muted">Choose from our delicious selection</p>
            </div>
            <div class="text-center">
                <button class="category-btn active" data-category="all">All Items</button>
                <button class="category-btn" data-category="meat">Meat</button>
                <button class="category-btn" data-category="seafood">Seafood</button>
                <button class="category-btn" data-category="grains">Grains</button>
                <button class="category-btn" data-category="beverages">Beverages</button>
            </div>
        </div>
    </section>

    <!-- Menu Items -->
    <section class="py-5">
        <div class="container">
            <div class="row" id="menuItems">
                <!-- Menu items will be loaded here -->
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1606755962773-d324e74534a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Chicken" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Grilled Chicken</h5>
                            <p class="card-text text-muted">Juicy grilled chicken with special spices</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱150.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="1" data-name="Grilled Chicken" data-price="150.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1563379926898-05f4575a45d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Pork" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Pork BBQ</h5>
                            <p class="card-text text-muted">Sweet and savory pork barbecue</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱180.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="2" data-name="Pork BBQ" data-price="180.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1586190848861-99aa4a171e90?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Fish" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Grilled Fish</h5>
                            <p class="card-text text-muted">Fresh grilled fish with lemon butter</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱120.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="3" data-name="Grilled Fish" data-price="120.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Rice" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Steamed Rice</h5>
                            <p class="card-text text-muted">Freshly steamed white rice</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱50.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="4" data-name="Steamed Rice" data-price="50.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1622483767028-3f66f32aef97?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Coke" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Soft Drinks</h5>
                            <p class="card-text text-muted">Coke, Sprite, or Royal</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱25.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="5" data-name="Soft Drinks" data-price="25.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card menu-card">
                        <img src="https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" class="card-img-top" alt="Ice Cream" height="200">
                        <div class="card-body">
                            <h5 class="card-title">Ice Cream</h5>
                            <p class="card-text text-muted">Vanilla, Chocolate, or Strawberry</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="h5 text-primary mb-0">₱60.00</span>
                                <button class="btn btn-primary add-to-cart" data-id="6" data-name="Ice Cream" data-price="60.00">
                                    <i class="fas fa-plus"></i> Add to Cart
                                </button>
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
            
            <div class="flex-grow-1 p-3" id="cartItems">
                <!-- Cart items will appear here -->
                <div class="text-center text-muted py-5">
                    <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                    <p>Your cart is empty</p>
                </div>
            </div>
            
            <div class="p-3 border-top">
                <div class="d-flex justify-content-between mb-2">
                    <strong>Total:</strong>
                    <strong id="cartTotal">₱0.00</strong>
                </div>
                <div class="mb-3">
                    <label class="form-label">Table Number</label>
                    <input type="number" class="form-control" id="tableNumber" min="1" placeholder="Enter table number" required>
                </div>
                
                <!-- Loading Indicator -->
                <div class="loading" id="loadingIndicator">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Processing your order...</p>
                </div>
                
                <button class="btn btn-success w-100" onclick="placeOrder()" id="placeOrderBtn">
                    <i class="fas fa-paper-plane me-2"></i>Place Order
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];
        
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
                toggleCart(); // Open cart when item added
            });
        });
        
        function updateCart() {
            const cartItems = document.getElementById('cartItems');
            const cartCount = document.getElementById('cartCount');
            const cartTotal = document.getElementById('cartTotal');
            
            // Update cart count
            cartCount.textContent = cart.reduce((total, item) => total + item.quantity, 0);
            
            // Update cart items
            if (cart.length === 0) {
                cartItems.innerHTML = `
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-shopping-cart fa-3x mb-3"></i>
                        <p>Your cart is empty</p>
                    </div>
                `;
            } else {
                cartItems.innerHTML = cart.map(item => `
                    <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                        <div>
                            <h6 class="mb-1">${item.name}</h6>
                            <small class="text-muted">₱${item.price.toFixed(2)} each</small>
                        </div>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.id}', -1)">-</button>
                            <span class="mx-2">${item.quantity}</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="updateQuantity('${item.id}', 1)">+</button>
                            <button class="btn btn-sm btn-danger ms-2" onclick="removeFromCart('${item.id}')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `).join('');
            }
            
            // Update total
            const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
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
            cart = cart.filter(item => item.id !== itemId);
            updateCart();
        }
        
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
            
            // Show loading, hide button
            placeOrderBtn.style.display = 'none';
            loadingIndicator.style.display = 'block';
            
            // Prepare order data for backend
            const orderData = {
                table_number: parseInt(tableNumber),
                items: cart.map(item => ({
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price
                }))
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
                    alert(`✅ Order placed successfully!\nOrder Number: ${data.order_number}\nTable: ${tableNumber}\nTotal: ${document.getElementById('cartTotal').textContent}`);
                    
                    // Clear cart
                    cart = [];
                    updateCart();
                    document.getElementById('tableNumber').value = '';
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
            });
        });
    </script>
</body>
</html>