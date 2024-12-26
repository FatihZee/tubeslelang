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
                                <h1 class="text-white mb-4">Auction Details</h1>

                                <!-- Display Auction Details -->
                                <div class="details-container text-white mb-4">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>ID:</strong></div>
                                        <div class="col-md-8">{{ $auction->id }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Product Name:</strong></div>
                                        <div class="col-md-8">{{ $auction->product->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Status:</strong></div>
                                        <div class="col-md-8">{{ ucfirst($auction->status) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Created At:</strong></div>
                                        <div class="col-md-8">{{ $auction->created_at->format('d M Y H:i') }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Updated At:</strong></div>
                                        <div class="col-md-8">{{ $auction->updated_at->format('d M Y H:i') }}</div>
                                    </div>
                                </div>

                                <!-- Display Product Image -->
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/' . ($auction->product->image ?? 'default.jpg')) }}" 
                                         alt="{{ $auction->product->name }}" 
                                         class="img-thumbnail shadow" 
                                         style="width: 300px; height: auto; background: rgba(255, 255, 255, 0.1);">
                                </div>

                                <!-- Action Buttons -->
                                <div class="text-end mt-4">
                                    <a href="{{ route('auctions.index') }}" 
                                       class="btn btn-light btn-sm me-2 px-4">Back</a>
                                    <a href="{{ route('auctions.edit', $auction) }}" 
                                       class="btn btn-primary btn-sm me-2 px-4">Edit</a>
                                    <form action="{{ route('auctions.destroy', $auction) }}" 
                                          method="POST" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this auction?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
                                    </form>
                                </div>

                                <!-- Winner Section -->
                                @if (auth()->user()->role === 'admin')
                                    @if ($auction->status === 'closed' && !$auction->winner_id)
                                        <div class="text-center mt-4">
                                            <form action="{{ route('auctions.selectWinner', $auction->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm px-4">Select Winner</button>
                                            </form>
                                        </div>
                                    @elseif ($auction->winner_id)
                                        <div class="winner-info mt-4 text-white text-center p-3" style="background: rgba(255, 255, 255, 0.1); border-radius: 1em;">
                                            <h4 class="mb-3">Winner Information</h4>
                                            <p class="mb-2"><strong>Winner:</strong> {{ $auction->winner->name }}</p>
                                            <p class="mb-0"><strong>Bid Price:</strong> {{ $auction->bids->where('user_id', $auction->winner_id)->first()->bid_price }}</p>
                                        </div>
                                    @endif
                                @endif
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

.winner-info {
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}
</style>
@endsection