<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Lelang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
        /* General Layout Styles */
        body {
            font-family: 'Poppins', sans-serif;
            overflow-x: hidden; 
        }

        /* Navbar/Header Styling */
        .navbar {
            background: linear-gradient(135deg, #6f42c1 0%, rgb(192, 171, 231) 100%) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 0.2rem 1rem;
        }
        .navbar-nav {
            color: #f3f1f8 !important;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 1px;
            font-size: 1.25rem;
        }

        .navbar-brand img {
            height: 40px;
            object-fit: contain;
        }
        .navbar .nav-link {
            background-color: rgb(231, 219, 255);
            padding: 0.5rem 1rem;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .navbar .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Sidebar Styling */
        .col-md-2.bg-light {
            background-color: white !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }
        .nav-item .nav-link {
            color: #666 !important;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }
        .nav-item .nav-link:hover {
            background-color: #f3f1f8;
            color: #6f42c1 !important;
            transform: translateX(5px);
        }
        .nav-item .nav-link.active {
            background-color: #f3f1f8;
            color: #6f42c1 !important;
            font-weight: 500;
        }

        /* Content Styling */
        .content-wrapper {
            background-image: url("{{ asset('login.png') }}");
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: auto;
            padding: 40px;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.jpg') }}" alt="Logo" height="30">
                <span class="ms-2" style="color: white;">Lelangan</span>
                <span style="color: #4eefec; font-family: 'Bangers', cursive;">App</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto"></ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-dark" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('users.show', \Illuminate\Support\Facades\Auth::user()->id_user) }}"><i class="bi bi-person"></i> My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid" style="padding: 0;">
        <div class="row" style="height: 100vh;">
            <!-- Sidebar Section -->
            <div class="col-md-2 bg-light vh-100">
                <div class="d-flex flex-column p-2" style="height: 100%;">
                    <h5 class="text-center py-3">Admin Menu</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2">
                            <a href="{{ route('dashboard') }}" class="nav-link text-dark"><i class="bi bi-house"></i> Dashboard</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('products.index') }}" class="nav-link text-dark"><i class="bi bi-basket3"></i> Products</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('auctions.index') }}" class="nav-link text-dark"><i class="bi bi-cart2"></i> Auctions</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('users.index') }}" class="nav-link text-dark"><i class="bi bi-journal"></i> Daftar User</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('transactions.index') }}" class="nav-link text-dark"><i class="bi bi-cash"></i> Transactions</a>
                        </li>
                        <li class="nav-item mb-2">
                            <a href="{{ route('feedbacks.index') }}" class="nav-link text-dark"><i class="bi bi-chat"></i> Feedbacks</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content Section -->
            <div class="col-md-10 content-wrapper">
                <div class="container mt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
