@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('title', 'Product List')

@section('content')
<section class="intro">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Products List</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Add Create Product Button -->
        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Create Product</a>

        <!-- Add Export PDF Button -->
        @if (Auth::user()->role === 'admin')
            <a href="{{ route('products.export-pdf') }}" class="btn btn-secondary rounded-pill mb-3">Export to PDF</a>
        @endif

        <div class="table-responsive">
            <table class="table table-hover text-white mb-0">
                <thead class="table-header">
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr class="table-row">
                     <td>{{ $product->id }}</td>
                     <td>
                        @if ($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @else
                            <p class="text-white-50">No Image</p>
                        @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td>
                                <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm rounded-pill">View</a>
                                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm rounded-pill">Edit</a>
                                <!-- Delete Form -->
                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to delete this product?')">Delete</button>
                                    </form>
                                    </td>
                                    </tr>
                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Styles -->
    <style>
        html, body, .intro {
            height: 100%;
        }

        .mask-custom {
            background: rgba(24, 24, 16, 0.2);
            border-radius: 1em;
            backdrop-filter: blur(25px);
            border: 2px solid rgba(255, 255, 255, 0.05);
            box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
            background-image: url('{{ asset("bg.jpg") }}');
        }

        .table-responsive {
            border-radius: 1em;
            background: rgba(115, 2, 2, 0.05);
            backdrop-filter: blur(15px);
        }

        .table-header {
            background: rgba(255, 255, 255, 0.1);
        }

        .table {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .table tr {
            border: none;
        }

        .table td, .table th {
            border: none !important;
        }

        .table-hover tbody tr:hover {
            background: rgba(252, 252, 252, 0.35);
            cursor: pointer;
        }

        button, a.btn {
            transition: transform 0.2s ease;
        }

        button:hover, a.btn:hover {
            transform: scale(0.95);
        }
    </style>
@endsection
