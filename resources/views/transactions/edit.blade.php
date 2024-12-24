@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4">
    <h1>Edit Transaction</h1>
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <select name="user_id" id="user_id" class="form-control">
                @foreach ($users as $user)
                    <option value="{{ $user->id_user }}" {{ $transaction->user_id == $user->id_user ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="bid_id" class="form-label">Bid</label>
            <select name="bid_id" id="bid_id" class="form-control">
                @foreach ($bids as $bid)
                    <option value="{{ $bid->id }}" {{ $transaction->bid_id == $bid->id ? 'selected' : '' }}>
                        {{ $bid->id }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" name="nominal" id="nominal" class="form-control" value="{{ $transaction->nominal }}" min="0">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Image</label>
            <input type="text" name="image" id="image" class="form-control" value="{{ $transaction->image }}">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ $transaction->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
