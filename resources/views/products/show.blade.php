@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('title', 'Product Details')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Product Details</h1>

        <div class="card">
            <div class="card-body">
                <!-- Display Product Image -->
                @if ($product->image)
                    <div class="mb-3 text-center">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="max-width: 100%; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
                    </div>
                @endif

                <p><strong>Name:</strong> {{ $product->name }}</p>
                <p><strong>Description:</strong> {{ $product->description }}</p>
                <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                <p><strong>Stock:</strong> {{ $product->stock }}</p>
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Product List</a>
        </div>
    </div>
@endsection