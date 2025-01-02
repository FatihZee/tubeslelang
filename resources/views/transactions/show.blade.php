@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4 fade-in">
    <section class="intro">
        <div class="mask mask-custom d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Transaction Details</h1>
                                <h5 class="text-white mb-4">Transaction ID: {{ $transaction->id }}</h5>
                                <p class="text-white"><strong>User:</strong> {{ $transaction->user->name }}</p>
                                <p class="text-white"><strong>Bid ID:</strong> {{ $transaction->bid->id }}</p>
                                <p class="text-white"><strong>Nominal:</strong> ${{ number_format($transaction->nominal, 2) }}</p>
                                <p class="text-white"><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
                                <p class="text-white"><strong>Created At:</strong> {{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
                                <p class="text-white"><strong>Image:</strong></p>
                                <img src="{{ asset('storage/' . $transaction->image) }}" alt="Transaction Image" class="img-thumbnail" style="width: 200px;">
                                <div class="text-end mt-3">
                                    <a href="{{ route('transactions.index') }}" class="btn btn-primary">Back to Transactions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

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