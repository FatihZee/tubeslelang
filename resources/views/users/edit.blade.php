@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card mask-custom">
                <div class="card-body">
                    <h1 class="text-white mb-4">Edit User</h1>

                    <!-- Display Validation Errors -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Edit User Form -->
                    <form action="{{ route('users.update', $user->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label text-white">Name</label>
                            <input type="text" name="name" id="name" class="form-control bg-light bg-opacity-25 text-white border-light" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label text-white">Email</label>
                            <input type="email" name="email" id="email" class="form-control bg-light bg-opacity-25 text-white border-light" 
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="username" class="form-label text-white">Username</label>
                            <input type="text" name="username" id="username" class="form-control bg-light bg-opacity-25 text-white border-light" 
                                   value="{{ old('username', $user->username) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label text-white">Password <small>(Leave empty if not changing)</small></label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control bg-light bg-opacity-25 text-white border-light" aria-describedby="password-eye">
                                <button type="button" class="btn btn-dark bg-opacity-10 border-light" id="password-eye" onclick="togglePasswordVisibility()">
                                    <i class="fa fa-eye text-white" id="eye-icon"></i>
                                </button>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="javascript:history.back()" class="btn rounded-pill btn-light btn-sm me-2 px-4">Back</a>
                            <button type="submit" class="btn btn-primary rounded-pill btn-sm px-4">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

<style>
/* Container Styling */
html,
body {
    height: 100%;
    background: rgba(24, 24, 16, 0.9) url('{{ asset("bg.jpg") }}') no-repeat center center fixed;
    background-size: cover;
}

/* Card Styling */
.mask-custom {
    background: rgba(24, 24, 16, .2);
    border-radius: 2em;
    backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.05);
    background-clip: padding-box;
    box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
}

.card-body {
    padding: 2.5rem;
}

/* Form Styling */
.form-control {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
    border-radius: 8px;
}

.form-control:focus {
    background-color: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

.form-label {
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Button Styling */
.btn {
    padding: 0.5rem 1.5rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}
</style>
@endsection
