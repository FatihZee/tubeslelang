@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('title', 'Product Details')

@section('content')
<section class="intro">
    <div class="bg-image h-100">
        <div class="mask d-flex align-items-center h-100">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-8">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Product Details</h1>
                               <!-- Display Product Image -->
                               @if ($product->image)
                                    <div class="text-center mb-4">
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" 
                                             class="img-thumbnail shadow zoom-image" 
                                             style="max-width: 300px; height: auto;">
                                    </div>
                                @endif

                                <!-- Product Details -->
                                <div class="details-container text-white mb-4">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Name:</strong></div>
                                        <div class="col-md-8">{{ $product->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Description:</strong></div>
                                        <div class="col-md-8">{{ $product->description }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Price:</strong></div>
                                        <div class="col-md-8">${{ number_format($product->price, 2) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Stock:</strong></div>
                                        <div class="col-md-8">{{ $product->stock }}</div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="text-end mt-4">
                                    <a href="{{ route('products.index') }}" 
                                       class="btn rounded-pill btn-light btn-sm px-4">Back to Product List</a>
                                </div>
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
    background-image: url('{{ asset("bg.jpg") }}');
}

.details-container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1em;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.details-container .row {
    margin: 0;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.details-container .row:last-child {
    border-bottom: none;
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

.zoom-image {
    transition: transform 0.3s ease;
    cursor: pointer;
}

.zoom-image:hover {
    transform: scale(1.1);
}
</style>
@endsection
