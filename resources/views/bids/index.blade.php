@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content ')
    <section class="intro fade-in">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Bids for {{ $auction->product->name }}</h1>

                                <!-- Menampilkan harga bid tertinggi -->
                                <p class="text-white"><strong>Highest Bid:</strong> ${{ number_format($highestBid, 2) }}</p>

                                <!-- Tombol untuk Membuat Bid Baru -->
                                <a href="{{ route('bids.create', $auction->id) }}" class="btn btn-primary rounded-pill mb-3">Place New Bid</a>
                                <a href="{{ route('auctions.index', $auction->id) }}" class="btn btn-secondary rounded-pill mb-3">Back</a>

                                <!-- Add Export PDF Button -->
                                @if (Auth::user()->role === 'admin' || Auth::check())
                                    <a href="{{ route('bids.export-pdf', ['auction' => $auction->id]) }}" class="btn btn-secondary rounded-pill mb-3">Export to PDF</a>
                                @endif

                                @if ($bids->isEmpty())
                                    <p class="text-white">No bids yet. Place your first bid now!</p>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover text-white mb-0">
                                            <thead>
                                                <tr class="table-header">
                                                    <th>Product</th>
                                                    <th>Bid Price</th>
                                                    <th>Bid Time</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($bids as $bid)
                                                    <tr class="table-row">
                                                        <td>{{ $auction->product->name }}</td>
                                                        <td>${{ number_format($bid->bid_price, 2) }}</td>
                                                        <td>{{ $bid->bid_time }}</td>
                                                        <td>
                                                            <a href="{{ route('bids.show', ['auction' => $auction->id, 'bid' => $bid->id]) }}" class="btn btn-info btn-sm rounded-pill">View</a>
                                                            <a href="{{ route('bids.edit', ['auction' => $auction->id, 'bid' => $bid->id]) }}" class="btn btn-warning btn-sm rounded-pill">Edit</a>
                                                            <form action="{{ route('bids.destroy', ['auction' => $auction->id, 'bid' => $bid->id]) }}" method="POST" style="display:inline;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure?')">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
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
@endsection
