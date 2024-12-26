@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<section class="intro">
    <div class="bg-image h-100" style="background-image: url(https://mdbootstrap.com/img/Photos/new-templates/glassmorphism-article/img7.jpg);">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Auctions</h1>

                                <!-- Admin Buttons -->
                                @if (auth()->user()->role === 'admin')
                                    <div class="mb-3">
                                        <a href="{{ route('auctions.create') }}" class="btn btn-primary me-2">Create Auction</a>
                                        <a href="{{ route('auctions.export-pdf') }}" class="btn btn-secondary">Export to PDF</a>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-borderless text-white mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">ID</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Admin Name</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Winner</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($auctions as $auction)
                                                <tr>
                                                    <th scope="row">{{ $auction->id }}</th>
                                                    <td>
                                                        @if ($auction->product->image)
                                                            <img src="{{ asset('storage/' . $auction->product->image) }}" 
                                                                 alt="{{ $auction->product->name }}" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 100px; height: auto;">
                                                        @else
                                                            <span class="text-white">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $auction->product->name }}</td>
                                                    <td>{{ $auction->admin->name }}</td>
                                                    <td><span class="badge bg-light text-dark">{{ ucfirst($auction->status) }}</span></td>
                                                    <td>
                                                        @if ($auction->winner_id && $auction->winner)
                                                            <span class="text-white">{{ $auction->winner->name }}</span>
                                                        @elseif (!$auction->winner_id && $auction->status === 'closed')
                                                            <span class="text-white-50">No winner selected yet</span>
                                                        @else
                                                            <span class="text-white-50">No winner yet</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (auth()->user()->role === 'admin')
                                                            <div class="btn-group">
                                                                <a href="{{ route('auctions.show', $auction) }}" class="btn btn-info btn-sm">View</a>
                                                                <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-warning btn-sm">Edit</a>
                                                                <form action="{{ route('auctions.destroy', $auction) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                                                </form>

                                                                @if ($auction->status === 'closed' && !$auction->winner_id)
                                                                    <form action="{{ route('auctions.selectWinner', $auction) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-success btn-sm">Select Winner</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @else
                                                            @if (!$auction->winner_id && $auction->status === 'open')
                                                                <a href="{{ route('bids.index', $auction) }}" class="btn btn-primary btn-sm">Bid Now</a>
                                                            @elseif ($auction->winner_id && $auction->winner_id == auth()->id())
                                                                <span class="badge bg-success">You won this auction!</span>
                                                                
                                                                @php
                                                                    $winningBid = $auction->bids->where('user_id', auth()->id())->first();
                                                                    $transaction = $winningBid ? $winningBid->transaction : null;
                                                                @endphp

                                                                @if(!$transaction)
                                                                    <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm">Bayar Sekarang</a>
                                                                @else
                                                                    @if($transaction->status === 'confirmed')
                                                                        <a href="{{ route('feedbacks.create', $transaction->id) }}" class="btn btn-primary btn-sm">Berikan Feedback</a>
                                                                    @else
                                                                        <span class="badge bg-info">Payment {{ ucfirst($transaction->status) }}</span>
                                                                    @endif
                                                                @endif
                                                            @elseif ($auction->winner_id)
                                                                <span class="badge bg-danger">You lost this auction</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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

table td,
table th {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
}

.mask-custom {
    background: rgba(24, 24, 16, .2);
    border-radius: 2em;
    backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.05);
    background-clip: padding-box;
    box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
}

.table-responsive {
    border-radius: 1em;
}

.btn-group {
    display: flex;
    gap: 0.25rem;
}

.card-body {
    padding: 2rem;
}
</style>
@endsection