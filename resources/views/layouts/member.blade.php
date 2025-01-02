<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Member Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <style>
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

        .navbar .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 8px;
        }

        /* Sidebar Styling */
        .col-md-2.bg-light {
            background-color: white !important;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Content Styling */
        .content-wrapper {
            background-image: url('{{ asset('login.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: auto;
            padding: 40px;
        }
        .content-wrapper {
            background-image: url('{{ asset('login.png') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: auto;
            padding: 40px;
        }
        
    </style>
    @stack('styles')
</head>
<body style="font-family: 'Poppins', sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('logo.jpg') }}" alt="Logo">
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
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ \Illuminate\Support\Facades\Auth::user()->nama_user }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('users.show', \Illuminate\Support\Facades\Auth::user()->id_user) }}"><i class="bi bi-person"></i> My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 bg-light vh-100">
                <h5 class="text-center py-3">Member Menu</h5>
                <ul class="nav flex-column">
                    <li class="nav-item mb-2">
                        <a href="{{ route('dashboard') }}" class="nav-link text-dark"><i class="bi bi-house"></i> Dashboard</a>
                    </li>
                    <li class="nav-item mb-2">
                        <a href="{{ route('auctions.index') }}" class="nav-link text-dark"><i class="bi bi-basket3"></i> Products</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10 content-wrapper">
                <div class="container mt-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
