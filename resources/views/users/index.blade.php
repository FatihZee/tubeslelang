@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <section class="intro">
        <div class="mask mask-custom d-flex align-items-center h-100">
            <div class="container">
                <h1 class="text-white m-3">Users list</h1>

                <!-- Button to Create New User -->
                <a href="{{ route('users.create') }}" class="btn btn-primary rounded-pill mb-3">Create User</a>

                <!-- Button to Export PDF -->
                @if (Auth::user()->role === 'admin')
                    <a href="{{ route('users.exportCsv') }}" class="btn btn-success rounded-pill mb-3">Export to CSV</a>
                    <a href="{{ route('users.exportPdf') }}" class="btn btn-secondary rounded-pill mb-3">Export to PDF</a>
                @endif

                <!-- User Table -->
                <div class="table-responsive">
                    <table class="table table-hover text-white mb-4">
                        <thead class="table-header">
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr class="table-row">
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td class="text-center">
                                        <!-- Show Button -->
                                        <a href="{{ route('users.show', $user->id_user) }}" class="btn btn-info btn-sm rounded-pill">
                                            View
                                        </a>

                                        <!-- Edit Button -->
                                        <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning btn-sm rounded-pill">
                                            Edit
                                        </a>

                                        <!-- Delete Form -->
                                        <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm rounded-pill" 
                                                onclick="return confirm('Are you sure you want to delete this user?');">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
