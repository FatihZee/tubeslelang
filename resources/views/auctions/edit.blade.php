@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<section class="intro">
    <div class="bg-image h-100" style="background-image: url(https://mdbootstrap.com/img/Photos/new-templates/glassmorphism-article/img7.jpg);">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Edit Auction</h1>

                                <form action="{{ route('auctions.update', $auction) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Dropdown Pilih Product -->
                                    <div class="mb-4">
                                        <label for="product_id" class="form-label text-white">Product:</label>
                                        <select name="product_id" id="product_id" 
                                            class="form-select bg-light bg-opacity-25 text-white border-light" 
                                            onchange="updateProductImage()">
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" 
                                                        data-image="{{ asset('storage/' . $product->image) }}"
                                                        {{ $product->id == $auction->product_id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tempat Menampilkan Gambar Produk -->
                                    <div id="product-image-container" class="mb-4 text-center">
                                        <img id="product-image" 
                                             src="{{ asset('storage/' . $auction->product->image) }}" 
                                             alt="{{ $auction->product->name }}" 
                                             class="img-thumbnail shadow" 
                                             style="width: 200px; height: auto; background: rgba(255, 255, 255, 0.1);">
                                    </div>

                                    <!-- Dropdown Pilih Status -->
                                    <div class="mb-4">
                                        <label for="status" class="form-label text-white">Status:</label>
                                        <select name="status" id="status" 
                                            class="form-select bg-light bg-opacity-25 text-white border-light">
                                            <option value="open" {{ $auction->status == 'open' ? 'selected' : '' }}>Open</option>
                                            <option value="closed" {{ $auction->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                        </select>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <div class="text-end mt-4">
                                        <a href="javascript:history.back()" 
                                           class="btn rounded-pill btn-light btn-sm me-2 px-4">Back</a>
                                        <button type="submit" 
                                                class="btn btn-primary rounded-pill btn-sm px-4">Update Auction</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
html,
body,
.intro {
    height: 100%;
}

.mask-custom {
    background: rgba(24, 24, 16, .2);
    border-radius: 2em;
    backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.05);
    background-clip: padding-box;
    box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
}

/* Form Styling */
.form-select {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
}

.form-select:focus {
    background-color: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

.form-select option {
    background-color: rgba(24, 24, 16, 0.9);
    color: white;
}

.form-label {
    font-weight: 500;
    letter-spacing: 0.5px;
}

.img-thumbnail {
    border: 2px solid rgba(255, 255, 255, 0.1);
    background-color: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
}

.btn {
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.card-body {
    padding: 2.5rem;
}
</style>

@endsection

@section('scripts')
<script>
    function updateProductImage() {
        const selectedOption = document.querySelector('#product_id option:checked');
        const productImage = document.querySelector('#product-image');
        const imageUrl = selectedOption.getAttribute('data-image');
        
        productImage.src = imageUrl ? imageUrl : '';
        productImage.alt = selectedOption.textContent || 'No Image';
    }
</script>
@endsection