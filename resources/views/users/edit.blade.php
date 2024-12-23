@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4">Edit User</h1>

        <!-- Display Validation Errors -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit User Form -->
        <form action="{{ route('users.update', $user->id_user) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password <small>(Leave empty if not changing)</small></label>
                <div class="input-group">
                    <input type="password" name="password" id="password" class="form-control" aria-describedby="password-eye">
                    <button type="button" class="btn btn-outline-secondary" id="password-eye" onclick="togglePasswordVisibility()">
                        <i class="fa fa-eye" id="eye-icon"></i>
                    </button>
                    
                </div>
                <button type="submit" class="btn btn-primary mt-4 ">Update</button>
                    <a href="javascript:history.back()" class="btn btn-secondary mt-4">Back</a>
            </div>

            
        </form>
    </div>

    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById('password');
            var eyeIcon = document.getElementById('eye-icon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
@endsection

