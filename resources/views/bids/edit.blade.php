@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <h1>Edit Bid</h1>

    <form action="{{ route('bids.update', ['auction' => $auction->id, 'bid' => $bid->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="bid_price">Bid Price</label>
            <input type="number" name="bid_price" id="bid_price" class="form-control" 
                   value="{{ old('bid_price', $bid->bid_price) }}" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Update Bid</button>
        <a href="{{ route('bids.index', $auction->id) }}" class="btn btn-secondary mt-3">Back</a>
    </form>
@endsection