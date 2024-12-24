@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <h1>Bids for {{ $auction->product->name }}</h1>

    <!-- Menampilkan harga bid tertinggi -->
    <p><strong>Highest Bid:</strong> ${{ number_format($highestBid, 2) }}</p>

    <!-- Tombol untuk Membuat Bid Baru -->
    <a href="{{ route('bids.create', $auction->id) }}" class="btn btn-primary mb-3">Place New Bid</a>
    <a href="{{ route('auctions.index', $auction->id) }}" class="btn btn-secondary mb-3">Back</a>

    <!-- Add Export PDF Button -->
    @if (Auth::user()->role === 'admin' || Auth::check())
        <a href="{{ route('bids.export-pdf', ['auction' => $auction->id]) }}" class="btn btn-secondary mb-3">Export to PDF</a>
    @endif


    @if ($bids->isEmpty())
        <p>No bids yet. Place your first bid now!</p>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Bid Price</th>
                    <th>Bid Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bids as $bid)
                    <tr>
                        <td>{{ $auction->product->name }}</td>
                        <td>${{ number_format($bid->bid_price, 2) }}</td>
                        <td>{{ $bid->bid_time }}</td>
                        <td>
                            <a href="{{ route('bids.show', ['auction' => $auction->id, 'bid' => $bid->id]) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('bids.edit', ['auction' => $auction->id, 'bid' => $bid->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('bids.destroy', ['auction' => $auction->id, 'bid' => $bid->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection