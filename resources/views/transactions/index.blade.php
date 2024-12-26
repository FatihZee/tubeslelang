@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4">
    <h1>Transactions</h1>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary mb-3">Create Transaction</a>

    @if (Auth::user()->role === 'admin')
        <a href="{{ route('transactions.export-pdf') }}" class="btn btn-secondary mb-3">Export to PDF</a>
    @endif

    <div class="mb-3">
        <label for="showEntries" class="form-label">Show</label>
        <select id="showEntries" class="form-select" onchange="location = this.value;">
            <option value="{{ route('transactions.index', ['perPage' => 10]) }}" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
            <option value="{{ route('transactions.index', ['perPage' => 25]) }}" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
            <option value="{{ route('transactions.index', ['perPage' => 50]) }}" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
            <option value="{{ route('transactions.index', ['perPage' => 100]) }}" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
        </select>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead style="background-color:rgb(47, 105, 192); color: white;">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Bid</th>
                    <th>Nominal</th>
                    <th>Image</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ $transaction->bid->id }}</td>
                        <td>{{ $transaction->nominal }}</td>
                        <td>
                            <img src="{{ asset('storage/' . $transaction->image) }}" alt="Image" class="img-thumbnail" style="width: 100px;">
                        </td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection