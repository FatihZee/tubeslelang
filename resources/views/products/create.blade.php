@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('title', 'Add New Product')

@section('content')
    <div class="container mt-4">
        <h1>Add New Product</h1>

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

            <div class="mb-3">
                <label for="name" class="form-label">Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea name="description" id="description" class="form-control" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price:</label>
                <input type="number" name="price" id="price" value="{{ old('price') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stock:</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Product Image:</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="javascript:history.back()" class="btn btn-secondary ">Back</a>
        </form>
    </div>
@endsection