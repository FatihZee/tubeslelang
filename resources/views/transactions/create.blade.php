@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4">
    <h1>Create Transaction</h1>
    <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">User</label>
            <!-- Hanya menampilkan user yang sedang login -->
            <select name="user_id" id="user_id" class="form-control" readonly>
                <option value="{{ auth()->user()->id_user }}">{{ auth()->user()->name }}</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="bid_id" class="form-label">Bid</label>
            <select name="bid_id" id="bid_id" class="form-control" onchange="updateNominal()">
                <option value="" disabled selected>Select Winning Bid</option>
                @foreach ($bids as $bid)
                    <!-- Tampilkan bid yang dimenangkan -->
                    <option value="{{ $bid->id }}" data-price="{{ $bid->bid_price }}">
                        {{ $bid->auction->product->name }} - Bid Price: ${{ number_format($bid->bid_price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="nominal" class="form-label">Nominal</label>
            <input type="number" name="nominal" id="nominal" class="form-control" min="0" readonly required>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Proof of Payment</label>
            <input type="file" name="image" id="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="pending">Pending</option>
                <option value="confirmed">Confirmed</option>
                <option value="rejected">Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    function updateNominal() {
        const bidSelect = document.getElementById('bid_id');
        const selectedOption = bidSelect.options[bidSelect.selectedIndex];
        const bidPrice = selectedOption.getAttribute('data-price');
        document.getElementById('nominal').value = bidPrice || 0;
    }
</script>
@endsection