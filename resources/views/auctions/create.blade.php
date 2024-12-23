@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')
@section('content')
    <div class="container mt-4">
        <!-- Judul Halaman -->
        <h1 class="mb-4">Create Auction</h1>

        <!-- Form Create Auction -->
        <form action="{{ route('auctions.store') }}" method="POST">
            @csrf

            <!-- Dropdown Pilih Product -->
            <div class="mb-3">
                <label for="product_id" class="form-label">Product:</label>
                <select name="product_id" id="product_id" class="form-select" onchange="updateProductImage()">
                    @foreach ($products as $product)
                        <option value="{{ $product->id }}" data-image="{{ asset('storage/' . $product->image) }}">
                            {{ $product->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tempat Menampilkan Gambar Produk -->
            <div id="product-image-container" class="mb-4 text-center">
                <img id="product-image" 
                     src="{{ asset('storage/' . ($products->first()->image ?? 'default.jpg')) }}" 
                     alt="{{ $products->first()->name ?? 'No Image' }}" 
                     class="img-thumbnail" 
                     style="width: 200px; height: auto;">
            </div>

            <!-- Dropdown Pilih Admin -->
            <div class="mb-3">
                <label for="admin_id" class="form-label">Admin:</label>
                <select name="admin_id" id="admin_id" class="form-select">
                    @foreach ($admins as $admin)
                        <option value="{{ $admin->id_user }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Pilih Status -->
            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <select name="status" id="status" class="form-select">
                    <option value="open">Open</option>
                    <option value="closed">Closed</option>
                </select>
            </div>

            <!-- Tombol Submit -->
            <div class="text-early">
                <button type="submit" class="btn btn-primary">Create Auction</button>
                <a href="javascript:history.back()" class="btn btn-secondary ">Back</a>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
