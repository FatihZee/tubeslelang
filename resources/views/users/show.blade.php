@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <div class="container mt-4">
        <!-- Card untuk User Details -->
        <div class="card shadow-sm">
            <div class="card-header bg-light text-black">
                <h4 class="mb-0">User Details</h4>
            </div>
            <div class="card-body">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Username:</strong> {{ $user->username }}</p>
                <a href="{{ route('users.edit', $user->id_user) }}" class="btn btn-primary ms-2">Edit Profile</a>
                <a href="javascript:history.back()" class="btn btn-secondary">Back</a>
            </div>           
        </div>
    </div>
@endsection
