@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4">
    <h1>Transaction Details</h1>
    <div class="mb-3">
        <strong>ID:</strong> {{ $transaction->id }}
    </div>
    <div class="mb-3">
        <strong>User:</strong> {{ $transaction->user->name }}
    </div>
    <div class="mb-3">
        <strong>Bid:</strong> {{ $transaction->bid->id }}
    </div>
    <div class="mb-3">
        <strong>Nominal:</strong> {{ $transaction->nominal }}
    </div>
    <div class="mb-3">
        <strong>Image:</strong>
        <img src="{{ asset('storage/' . $transaction->image) }}" alt="Image" style="width: 150px;">
    </div>
    <div class="mb-3">
        <strong>Status:</strong> {{ ucfirst($transaction->status) }}
    </div>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection