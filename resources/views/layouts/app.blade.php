<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Lelang')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>
<body style="font-family: 'Poppins', sans-serif;">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}"><i class="bi bi-shop"></i> LelangApp</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end ">
                            <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()->id_user) }}">My Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
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
                        <!-- Tambahan Menu Transactions -->
                        <li class="nav-item mb-2">
                            <a href="{{ route('transactions.index') }}" class="nav-link text-dark"><i class="bi bi-currency-exchange"></i> Transactions</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
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
