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
                                        <a href="{{ route('auctions.create') }}" class="btn btn-primary me-2 rounded-pill">Create Auction</a>
                                        <a href="{{ route('auctions.export-pdf') }}" class="btn btn-secondary rounded-pill">Export to PDF</a>

                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-hover text-white mb-0">
                                        <thead>
                                            <tr class="table-header">
                                                <th scope="col" class="text-white">ID</th>
                                                <th scope="col" class="text-white">Image</th>
                                                <th scope="col" class="text-white">Product Name</th>
                                                <th scope="col" class="text-white">Admin Name</th>
                                                <th scope="col" class="text-white">Status</th>
                                                <th scope="col" class="text-white">Winner</th>
                                                <th scope="col" class="text-white">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($auctions as $auction)
                                                <tr class="table-row">
                                                    <th scope="row" class="text-white">{{ $auction->id }}</th>
                                                    <td class="text-white">
                                                        @if ($auction->product->image)
                                                            <img src="{{ asset('storage/' . $auction->product->image) }}" 
                                                                 alt="{{ $auction->product->name }}" 
                                                                 class="img-thumbnail" 
                                                                 style="width: 100px; height: auto;">
                                                        @else
                                                            <span class="text-white">No Image</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-white">{{ $auction->product->name }}</td>
                                                    <td class="text-white">{{ $auction->admin->name }}</td>
                                                    <td class="text-white"><span class="badge bg-light text-dark">{{ ucfirst($auction->status) }}</span></td>
                                                    <td class="text-white">
                                                        @if ($auction->winner_id && $auction->winner)
                                                            <span>{{ $auction->winner->name }}</span>
                                                        @elseif (!$auction->winner_id && $auction->status === 'closed')
                                                            <span class="text-white-50">No winner selected yet</span>
                                                        @else
                                                            <span class="text-white-50">No winner yet</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-white">
                                                        @if (auth()->user()->role === 'admin')
                                                            <div class="btn-group">
                                                                <a href="{{ route('auctions.show', $auction) }}" class="btn rounded-pill btn-info btn-sm text-white">View</a>
                                                                <a href="{{ route('auctions.edit', $auction) }}" class="btn rounded-pill btn-warning btn-sm text-white">Edit</a>
                                                                <form action="{{ route('auctions.destroy', $auction) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn rounded-pill btn-danger btn-sm text-white" onclick="return confirm('Are you sure?')">Delete</button>
                                                                </form>
                                    
                                                                @if ($auction->status === 'closed' && !$auction->winner_id)
                                                                    <form action="{{ route('auctions.selectWinner', $auction) }}" method="POST" class="d-inline">
                                                                        @csrf
                                                                        <button type="submit" class="btn rounded-pill btn-success btn-sm text-white">Select Winner</button>
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        @else
                                                            @if (!$auction->winner_id && $auction->status === 'open')
                                                                <a href="{{ route('bids.index', $auction) }}" class="btn btn-primary rounded-pill btn-sm text-white">Bid Now</a>
                                                            @elseif ($auction->winner_id && $auction->winner_id == auth()->id())
                                                                <span class="badge bg-success text-white">You won this auction!</span>
                                                                
                                                                @php
                                                                    $winningBid = $auction->bids->where('user_id', auth()->id())->first();
                                                                    $transaction = $winningBid ? $winningBid->transaction : null;
                                                                @endphp
                                    
                                                                @if(!$transaction)
                                                                    <a href="{{ route('transactions.create') }}" class="btn rounded-pill btn-success btn-sm text-white">Bayar Sekarang</a>
                                                                @else
                                                                @if($transaction->status === 'confirmed')
                                                                    <span class="badge bg-info text-white">Payment Confirmed</span>
                                                                    <a href="{{ route('feedbacks.create', $transaction->id) }}" class="btn btn-primary rounded-pill btn-sm text-white ms-2 feedback-button" data-transaction-id="{{ $transaction->id }}">Berikan Feedback</a>
                                                                    @else
                                                                        <span class="badge bg-info text-white">Payment {{ ucfirst($transaction->status) }}</span>
                                                                    @endif
                                                                @endif
                                                            @elseif ($auction->winner_id)
                                                                <span class="badge bg-danger text-white">You lost this auction</span>
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
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(15px);
}

.table-header {
    background: rgba(255, 255, 255, 0.1);
}

.table-row {
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.table-row:hover {
    background: rgba(0, 221, 255, 0.434);
    transition: all 0.3s ease;
}

.btn-group {
    display: flex;
    gap: 0.25rem;
}

.card-body {
    padding: 2rem;
}

/* Memastikan teks tetap terbaca */
.table {
    color: #fff !important;
}

.table td, .table th {
    padding: 1rem;
    vertical-align: middle;
}

/* Memberikan border subtle */
.table > :not(caption) > * > * {
    border-bottom-color: rgba(255, 255, 255, 0.1);
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const feedbackButtons = document.querySelectorAll('.feedback-button');

        feedbackButtons.forEach(button => {
            const transactionId = button.getAttribute('data-transaction-id');
            
            // Cek Local Storage
            if (localStorage.getItem(`feedbackClicked_${transactionId}`)) {
                button.style.display = 'none';
            }

            // Event Listener klik
            button.addEventListener('click', () => {
                localStorage.setItem(`feedbackClicked_${transactionId}`, true);
            });
        });
    });
</script>
@endsection