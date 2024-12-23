@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container">
    <h1>All Feedbacks</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Transaction</th>
                <th>Feedback</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($feedbacks as $feedback)
            <tr>
                <td>{{ $feedback->id }}</td>
                <td>{{ $feedback->user->name }}</td>
                <td>{{ $feedback->transaction->id }}</td>
                <td>{{ $feedback->feedback }}</td>
                <td>
                    <a href="{{ route('feedbacks.show', $feedback->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('feedbacks.edit', $feedback->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('feedbacks.destroy', $feedback->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection