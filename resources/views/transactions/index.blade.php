@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container mt-4 fade-in">  <!--  class 'fade-in' -->
    <section class="intro">
        <div class="mask mask-custom d-flex align-items-center h-100">
            <div class="container">
                <h1 class="text-white m-3">Transactions</h1>
                
                <!-- Button to Create New Transaction -->
                <a href="{{ route('transactions.create') }}" 
                   class="btn btn-success rounded-pill mb-3"
                   style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
                   onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
                   onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                    Create Transaction
                </a>

                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('transactions.export-pdf') }}" 
                       class="btn btn-danger rounded-pill mb-3"
                       style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
                       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                        Export to PDF
                    </a>
                    <a href="{{ route('transactions.export-csv') }}" 
                       class="btn btn-warning rounded-pill mb-3"
                       style="transition: transform 0.3s ease, box-shadow 0.3s ease;"
                       onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.3)';"
                       onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                        Export to CSV
                    </a>
                @endif

                <div class="mb-3" style="max-width: 200px;">
                    <label for="showEntries" class="form-label text-white">Show Entries</label>
                    <select id="showEntries" class="form-select" onchange="location = this.value;">
                        <option value="{{ route('transactions.index', ['perPage' => 10]) }}" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                        <option value="{{ route('transactions.index', ['perPage' => 25]) }}" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                        <option value="{{ route('transactions.index', ['perPage' => 50]) }}" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                        <option value="{{ route('transactions.index', ['perPage' => 100]) }}" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                    </select>
                </div>
                
                <form action="{{ route('transactions.index') }}" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control me-2" placeholder="Search transactions" value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary rounded-pill">Search</button>
                    </div>
                </form>

                <!-- Transactions Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered text-white mb-0">
                        <thead class="table-header">
                            <tr>
                                <th class="text-white">ID</th>
                                <th class="text-white">User</th>
                                <th class="text-white">Bid</th>
                                <th class="text-white">Nominal</th>
                                <th class="text-white">Image</th>
                                <th class="text-white">Status</th>
                                <th class="text-white">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr class="table-row">
                                    <td class="text-white">{{ $transaction->id }}</td>
                                    <td class="text-white">{{ $transaction->user->name }}</td>
                                    <td class="text-white">{{ $transaction->bid->id }}</td>
                                    <td class="text-white">{{ $transaction->nominal }}</td>
                                    <td class="text-white">
                                        <img src="{{ asset('storage/' . $transaction->image) }}" alt="Image" class="img-thumbnail" style="width: 100px;">
                                    </td>
                                    <td class="text-white">{{ ucfirst($transaction->status) }}</td>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm rounded-pill">View</a>
                                        <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm rounded-pill">Edit</a>
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" onclick="return confirm('Are you sure you want to delete this transaction?');">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{ $transactions->appends(request()->input())->links() }}
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
