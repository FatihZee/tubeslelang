@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Auctions</h1>

        <!-- Button to Create Auction (Only for Admin) -->
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('auctions.create') }}" class="btn btn-primary mb-3">Create Auction</a>
        @endif

        <!-- Button to Export PDF (Only for Admin) -->
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('auctions.export-pdf') }}" class="btn btn-secondary mb-3">Export to PDF</a>
        @endif

        <!-- Auction Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary">
                    <tr>
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
                        <tr>
                            <td>{{ $auction->id }}</td>
                            <td>
                                @if ($auction->product->image)
                                    <img src="{{ asset('storage/' . $auction->product->image) }}" 
                                         alt="{{ $auction->product->name }}" 
                                         class="img-thumbnail" 
                                         style="width: 100px; height: auto;">
                                @else
                                    <p>No Image</p>
                                @endif
                            </td>
                            <td>{{ $auction->product->name }}</td>
                            <td>{{ $auction->admin->name }}</td>
                            <td>{{ ucfirst($auction->status) }}</td>

                            <td>
                                @if ($auction->winner_id && $auction->winner)
                                    <!-- Display Winner -->
                                    <p><strong>Winner:</strong> {{ $auction->winner->name }}</p>
                                @elseif (!$auction->winner_id && $auction->status === 'closed')
                                    <!-- If auction closed but no winner selected yet -->
                                    <p>No winner selected yet</p>
                                @else
                                    <p>No winner yet</p>
                                @endif
                            </td>

                            <td>
                                @if (auth()->user()->role === 'admin')
                                    <!-- Admin Actions -->
                                    <a href="{{ route('auctions.show', $auction) }}" class="btn btn-info btn-sm">View</a>
                                    <a href="{{ route('auctions.edit', $auction) }}" class="btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('auctions.destroy', $auction) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                            
                                    <!-- Button for Admin to Select Winner -->
                                    @if ($auction->status === 'closed' && !$auction->winner_id)
                                        <form action="{{ route('auctions.selectWinner', $auction) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Select Winner</button>
                                        </form>
                                    @endif
                                @else
                                    <!-- Member Actions -->
                                    @if (!$auction->winner_id && $auction->status === 'open')
                                        <!-- Bid Now button shown only if no winner yet and auction is open -->
                                        <a href="{{ route('bids.index', $auction) }}" class="btn btn-primary btn-sm">Bid Now</a>
                                        @elseif ($auction->winner_id && $auction->winner_id == auth()->id())
                                        <!-- Display a message if member is the winner -->
                                        <span class="badge bg-success">You won this auction!</span>
                                        <!-- Cek apakah sudah ada transaksi melalui bid -->
                                        @php
                                            $winningBid = $auction->bids->where('user_id', auth()->id())->first();
                                            $transaction = $winningBid ? $winningBid->transaction : null;
                                        @endphp
                                    
                                        @if(!$transaction)
                                            <!-- Tampilkan tombol Bayar Sekarang hanya jika belum ada transaksi -->
                                            <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm">Bayar Sekarang</a>
                                        @else
                                            @if($transaction->status === 'confirmed')
                                                <!-- Tampilkan tombol Berikan Feedback hanya jika pembayaran sudah confirmed -->
                                                <a href="{{ route('feedbacks.create', $transaction->id) }}" class="btn btn-primary btn-sm">Berikan Feedback</a>
                                            @else
                                                <!-- Tampilkan status pembayaran jika belum confirmed -->
                                                <span class="badge bg-info">Payment {{ ucfirst($transaction->status) }}</span>
                                            @endif
                                        @endif
                                    @elseif ($auction->winner_id)
                                        <!-- Display message if member is not the winner -->
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
@endsection