@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <section class="intro">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">All Feedbacks</h1>

                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <!-- Add Export PDF Button -->
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('feedbacks.export-pdf') }}" class="btn btn-secondary rounded-pill mb-3">Export to PDF</a>
                                @endif
                                
                                <div class="table-responsive">
                                    <table class="table table-hover text-white mb-0">
                                        <thead>
                                            <tr class="table-header">
                                                <th>ID</th>
                                                <th>User</th>
                                                <th>Transaction</th>
                                                <th>Feedback</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($feedbacks as $feedback)
                                                <tr class="table-row">
                                                    <td>{{ $feedback->id }}</td>
                                                    <td>{{ $feedback->user->name }}</td>
                                                    <td>{{ $feedback->transaction->id }}</td>
                                                    <td>{{ $feedback->feedback }}</td>
                                                    <td>
                                                        <a href="{{ route('feedbacks.show', $feedback->id) }}" class="btn btn-info btn-sm rounded-pill">View</a>
                                                        <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-warning btn-sm rounded-pill">Edit</a>
                                                        <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline;">
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
    </style>
@endsection
