@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<section class="intro fade-in">
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
                                    <a href="{{ route('auctions.create') }}" class="btn btn-primary rounded-pill">Create Auction</a>
                                    <!-- Dropdown Export -->
                                    <div class="dropdown d-inline">
                                        <button class="btn btn-secondary dropdown-toggle rounded-pill" type="button" id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                            Export File
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                            <li><a class="dropdown-item" href="{{ route('auctions.export-pdf') }}">Export to PDF</a></li>
                                            <li><a class="dropdown-item" href="{{ route('auctions.export-csv') }}">Export to CSV</a></li>
                                            <li><a class="dropdown-item" href="{{ route('auctions.export-json') }}">Export to JSON</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @endif

                            <!-- Auctions Table -->
                            <div class="table-responsive">
                                <table class="table table-hover text-white mb-0">
                                    <thead>
                                        <tr class="table-header">
                                            <th>ID</th>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Admin Name</th>
                                            <th>Status</th>
                                            <th>Winner</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auctions as $auction)
                                            <tr class="table-row">
                                                <th>{{ $auction->id }}</th>
                                                <td>
                                                    @if ($auction->product->image)
                                                        <img src="{{ asset('storage/' . $auction->product->image) }}" 
                                                             alt="{{ $auction->product->name }}" 
                                                             class="img-thumbnail" 
                                                             style="width: 100px; height: auto;">
                                                    @else
                                                        <span>No Image</span>
                                                    @endif
                                                </td>
                                                <td>{{ $auction->product->name }}</td>
                                                <td>{{ $auction->admin->name }}</td>
                                                <td><span class="badge bg-light text-dark">{{ ucfirst($auction->status) }}</span></td>
                                                <td>
                                                    @if ($auction->winner_id && $auction->winner)
                                                        <span>{{ $auction->winner->name }}</span>
                                                    @elseif (!$auction->winner_id && $auction->status === 'closed')
                                                        <span class="text-white-50">No winner selected yet</span>
                                                    @else
                                                        <span class="text-white-50">No winner yet</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (auth()->user()->role === 'admin')
                                                        <div class="btn-group">
                                                            <a href="{{ route('auctions.show', $auction) }}" class="btn btn-info btn-sm rounded-pill">View</a>
                                                            <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-warning btn-sm rounded-pill">Edit</a>
                                                            <form action="{{ route('auctions.destroy', $auction) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                                            </form>
                                                            @if ($auction->status === 'closed' && !$auction->winner_id)
                                                                <form action="{{ route('auctions.selectWinner', $auction) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-success btn-sm rounded-pill">Select Winner</button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    @else
                                                        @if (!$auction->winner_id && $auction->status === 'open')
                                                            <a href="{{ route('bids.index', $auction) }}" class="btn btn-primary btn-sm rounded-pill">Bid Now</a>
                                                        @elseif ($auction->winner_id && $auction->winner_id == auth()->id())
                                                            <span class="badge bg-success">You won this auction!</span>
                                                            @php
                                                                $winningBid = $auction->bids->where('user_id', auth()->id())->first();
                                                                $transaction = $winningBid ? $winningBid->transaction : null;
                                                            @endphp
                                                            @if (!$transaction)
                                                                <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm rounded-pill">Pay Now</a>
                                                            @else
                                                                @if ($transaction->status === 'confirmed')
                                                                    <span class="badge bg-info">Payment Confirmed</span>
                                                                    <a href="{{ route('feedbacks.create', $transaction->id) }}" class="btn btn-primary btn-sm rounded-pill ms-2 feedback-button" data-transaction-id="{{ $transaction->id }}">Give Feedback</a>
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
</section>

<!-- Styles -->
<style>
html, body, .intro {
    height: 100%;
}

.mask-custom {
    background: rgba(24, 24, 16, 0.2);
    border-radius: 1em;
    backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.05);
    box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    background-image: url('{{ asset("bg.jpg") }}');
}

.table-responsive {
    border-radius: 1em;
    background: rgba(115, 2, 2, 0.05);
    backdrop-filter: blur(15px);
}

.table-header {
    background: rgba(255, 255, 255, 0.1);
}

.table {
    border-collapse: collapse;
    border-spacing: 0;
}

.table tr {
    border: none;
}

.table td, .table th {
    border: none !important;
}

.table-hover tbody tr:hover {
    background: rgba(252, 252, 252, 0.35);
    cursor: pointer;
}

button, a.btn {
    transition: transform 0.2s ease;
}

button:hover, a.btn:hover {
    transform: scale(0.95);
}

.fade-in {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
</style>

<!-- Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const feedbackButtons = document.querySelectorAll('.feedback-button');

        feedbackButtons.forEach(button => {
            const transactionId = button.getAttribute('data-transaction-id');
            
            if (localStorage.getItem(`feedbackClicked_${transactionId}`)) {
                button.style.display = 'none';
            }

            button.addEventListener('click', () => {
                localStorage.setItem(`feedbackClicked_${transactionId}`, true);
            });
        });
    });
</script>
@endsection
