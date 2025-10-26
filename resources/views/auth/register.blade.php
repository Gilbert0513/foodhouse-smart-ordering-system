<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Foodhouse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(-45deg, #ff6b6b, #ffd93d, #6bcf7f, #4d96ff);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            overflow: hidden;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .register-box {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 320px;
            margin: 0 auto;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.2);
            transform: translateY(30px);
            opacity: 0;
            animation: slideUp 0.8s ease-out 0.3s forwards;
        }
        @keyframes slideUp {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .logo {
            text-align: center;
            margin-bottom: 25px;
            transform: scale(0.8);
            animation: scaleIn 0.6s ease-out 0.5s forwards;
        }
        @keyframes scaleIn {
            to { transform: scale(1); }
        }
        .form-control {
            font-size: 0.9rem;
            padding: 10px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            transform: translateX(20px);
            opacity: 0;
            animation: slideIn 0.5s ease-out forwards;
        }
        .form-control:nth-child(1) { animation-delay: 0.7s; }
        .form-control:nth-child(2) { animation-delay: 0.8s; }
        .form-control:nth-child(3) { animation-delay: 0.9s; }
        .form-control:nth-child(4) { animation-delay: 1.0s; }
        @keyframes slideIn {
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.1);
            transform: scale(1.02);
        }
        .btn {
            font-size: 0.9rem;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
            transform: translateY(20px);
            opacity: 0;
            animation: slideUpBtn 0.5s ease-out 1.1s forwards;
        }
        @keyframes slideUpBtn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        .links {
            transform: translateY(10px);
            opacity: 0;
            animation: fadeIn 0.5s ease-out 1.3s forwards;
        }
        @keyframes fadeIn {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .small-text { font-size: 0.75rem; }
        .floating {
            animation: floating 3s ease-in-out infinite;
        }
        @keyframes floating {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.02); }
        }
        .pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-10 col-sm-8 col-md-5 col-lg-4">
                <div class="register-box">
                    <div class="logo floating">
                        <h4 class="mb-2" style="color: #ff6b6b;">🍽️ Foodhouse</h4>
                        <p class="text-muted small-text">Join us today!</p>
                    </div>
                    
                    @if($errors->any())
                        <div class="alert alert-danger py-2 small-text mb-3" style="animation: slideIn 0.5s ease-out;">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="/register">
                        @csrf
                        <div class="mb-2">
                            <input type="text" class="form-control" name="name" placeholder="👤 Full Name" required>
                        </div>
                        <div class="mb-2">
                            <input type="email" class="form-control" name="email" placeholder="📧 Email" required>
                        </div>
                        <div class="mb-2">
                            <input type="password" class="form-control" name="password" placeholder="🔒 Password" required>
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="password_confirmation" placeholder="✅ Confirm Password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3 pulse" style="background: linear-gradient(45deg, #ff6b6b, #ff8e8e); border: none;">
                            ✨ Create Account
                        </button>
                    </form>

                    <div class="text-center small-text links">
                        Already have an account? 
                        <a href="/login" class="text-decoration-none fw-bold" style="color: #ff6b6b;">Sign In</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.querySelector('input[name="password"]').value;
            const confirmPassword = document.querySelector('input[name="password_confirmation"]').value;
            
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Passwords do not match!');
            }
        });
    </script>
</body>
</html>