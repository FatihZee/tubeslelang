@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <h1>Edit Auction</h1>
    
    <form action="{{ route('auctions.update', $auction) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Product Selection Dropdown -->
        <label for="product_id">Product:</label>
        <select name="product_id" id="product_id" onchange="updateProductImage()">
            @foreach ($products as $product)
                <option value="{{ $product->id }}" 
                        data-image="{{ asset('storage/' . $product->image) }}" 
                        {{ $product->id == $auction->product_id ? 'selected' : '' }}>
                    {{ $product->name }}
                </option>
            @endforeach
        </select>

        <!-- Display Product Image -->
        <div id="product-image-container" style="margin: 20px 0;">
            <img id="product-image" 
                 src="{{ asset('storage/' . $auction->product->image) }}" 
                 alt="{{ $auction->product->name }}" 
                 style="width: 200px; height: auto; border: 1px solid #ddd; padding: 5px; border-radius: 5px;">
        </div>

        <!-- Auction Status Selection -->
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="open" {{ $auction->status == 'open' ? 'selected' : '' }}>Open</option>
            <option value="closed" {{ $auction->status == 'closed' ? 'selected' : '' }}>Closed</option>
        </select>

        <!-- Submit Button -->
        <button type="submit">Update</button>
    </form>
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
