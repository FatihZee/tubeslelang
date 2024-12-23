@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Users list</h1>

        <!-- Button to Create New User -->
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Create User</a>

        <!-- User Table -->
        <div class="table-responsive">
            <table class="table table-bordered ">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">
                                <!-- Show Button -->
                                <a href="{{ route('users.show', $user->id_user) }}" class="btn btn-info btn-sm">
                                    View
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-warning btn-sm">
                                    Edit
                                </a>

                                <!-- Delete Form -->
                                <form action="{{ route('users.destroy', $user->id_user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
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
@endsection
