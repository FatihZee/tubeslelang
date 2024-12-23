@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <h1>Place Bid</h1>

    @php
        $highestBid = $auction->bids()->max('bid_price');
        $minimumBid = max($highestBid + 1, $auction->product->price + 1);
    @endphp

    <div class="border p-3 rounded">
    <form action="{{ route('bids.store', $auction->id) }}" method="POST">
        @csrf

        <p><strong>Product:</strong> {{ $auction->product->name }}</p>
        <p><strong>Starting Price:</strong> ${{ number_format($auction->product->price, 2) }}</p>
        
        @if ($highestBid)
            <p><strong>Highest Bid:</strong> ${{ number_format($highestBid, 2) }}</p>
        @else
            <p><strong>Highest Bid:</strong> No bids yet</p>
        @endif

        <div class="form-group">
            <label for="bid_price">Your Bid (minimum: ${{ number_format($minimumBid, 2) }}):</label>
            <input type="number" name="bid_price" id="bid_price" 
                   step="0.01" min="{{ $minimumBid }}" 
                   class="form-control" placeholder="Enter your bid" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Place Bid</button>
        <a href="{{ route('bids.index', $auction->id) }}" class="btn btn-secondary mt-3">Back</a>
    </form>
@endsection