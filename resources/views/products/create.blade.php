@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('title', 'Add New Product')

@section('content')
<section class="intro">
    <div class="bg-image h-100">
        <div class="mask d-flex align-items-center h-100">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-8">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Add New Product</h1>

     <!-- Display Validation Errors -->
     @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Product Form -->
                                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Input Name -->
                                    <div class="mb-4">
                                        <label for="name" class="form-label text-white">Name:</label>
                                        <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" required>
                                    </div>

                                    <!-- Input Description -->
                                    <div class="mb-4">
                                        <label for="description" class="form-label text-white">Description:</label>
                                        <textarea name="description" id="description" 
                                                  class="form-control bg-light bg-opacity-25 text-white border-light" 
                                                  rows="4" required>{{ old('description') }}</textarea>
                                    </div>

                                    <!-- Input Price -->
                                    <div class="mb-4">
                                        <label for="price" class="form-label text-white">Price:</label>
                                        <input type="number" name="price" id="price" value="{{ old('price') }}" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" required>
                                    </div>

                                    <!-- Input Stock -->
                                    <div class="mb-4">
                                        <label for="stock" class="form-label text-white">Stock:</label>
                                        <input type="number" name="stock" id="stock" value="{{ old('stock') }}" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" required>
                                    </div>

                                    <!-- Input Product Image -->
                                    <div class="mb-4">
                                        <label for="image" class="form-label text-white">Product Image:</label>
                                        <input type="file" name="image" id="image" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               accept="image/*">
                                    </div>

                                    <!-- Submit and Back Buttons -->
                                    <div class="text-end mt-4">
                                        <a href="javascript:history.back()" 
                                           class="btn rounded-pill btn-light btn-sm me-2 px-4">Back</a>
                                        <button type="submit" 
                                                class="btn btn-primary rounded-pill btn-sm px-4">Add Product</button>
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
    background-image: url('{{ asset("bg.jpg") }}');
}

.form-control {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

.form-label {
    font-weight: 500;
    letter-spacing: 0.5px;
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
