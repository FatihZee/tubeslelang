@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4">
    <h1>Transactions</h1>
    <a href="{{ route('transactions.create') }}" 
   class="btn btn-success mb-3" 
   style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
   onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
    Create Transaction
</a>

@if (Auth::user()->role === 'admin')
    <a href="{{ route('transactions.export-pdf') }}" 
       class="btn btn-danger mb-3" 
       style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
        Export to PDF
    </a>
@endif


    <div class="mb-3">
        <label for="showEntries" class="form-label">Show Entries</label>
        <select id="showEntries" class="form-select" onchange="location = this.value;">
            <option value="{{ route('transactions.index', ['perPage' => 10]) }}" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
            <option value="{{ route('transactions.index', ['perPage' => 25]) }}" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
            <option value="{{ route('transactions.index', ['perPage' => 50]) }}" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
            <option value="{{ route('transactions.index', ['perPage' => 100]) }}" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
        </select>
    </div>
    
    <form action="{{ route('transactions.index') }}" method="GET">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search transactions" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

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

    {{ $transactions->appends(request()->input())->links() }}
</div>
@endsection