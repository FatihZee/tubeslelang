@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<section class="intro">
    <div class="bg-image h-100">
        <div class="mask d-flex align-items-center h-100">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10 col-md-8">
                        <div class="card mask-custom">
                            <div class="card-body">
                                <h1 class="text-white mb-4">Create User</h1>

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

                                <!-- Form -->
                                <form action="{{ route('users.store') }}" method="POST" class="p-4">
                                    @csrf

                                    <!-- Name Field -->
                                    <div class="mb-4">
                                        <label for="name" class="form-label text-white">Name:</label>
                                        <input type="text" name="name" id="name" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               value="{{ old('name') }}" required>
                                    </div>

                                    <!-- Email Field -->
                                    <div class="mb-4">
                                        <label for="email" class="form-label text-white">Email:</label>
                                        <input type="email" name="email" id="email" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               value="{{ old('email') }}" required>
                                    </div>

                                    <!-- Username Field -->
                                    <div class="mb-4">
                                        <label for="username" class="form-label text-white">Username:</label>
                                        <input type="text" name="username" id="username" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               value="{{ old('username') }}" required>
                                    </div>

                                    <!-- Password Field -->
                                    <div class="mb-4">
                                        <label for="password" class="form-label text-white">Password:</label>
                                        <input type="password" name="password" id="password" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               required>
                                    </div>

                                    <!-- Role Selection -->
                                    <div class="mb-4">
                                        <label for="role" class="form-label text-white">Role:</label>
                                        <select name="role" id="role" 
                                                class="form-control bg-dark bg-opacity-75 text-white border-light" 
                                                required>
                                            <option class="" value="" disabled selected>Choose role</option>
                                            <option value="admin">Admin</option>
                                            <option value="member">Member</option>
                                        </select>

                                    </div>

                                    <!-- Buttons -->
                                    <div class="text-end mt-4">
                                        <a href="javascript:history.back()" 
                                           class="btn rounded-pill btn-light btn-sm me-2 px-4">Back</a>
                                        <button type="submit" 
                                                class="btn btn-primary rounded-pill btn-sm px-4">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
html,
body,
.intro {
    height: 100%;
  
}

.mask-custom {
    background: rgba(24, 24, 16, .2);
    border-radius: 2em;
    backdrop-filter: blur(25px);
    border: 2px solid rgba(255, 255, 255, 0.05);
    background-clip: padding-box;
    box-shadow: 10px 10px 10px rgba(46, 54, 68, 0.03);
    background-image: url('{{ asset("bg.jpg") }}');
}

.form-control {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
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

select.form-control:focus {
    background-color: rgba(0, 0, 0, 0.85) !important;
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}


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

.card-body {
    padding: 2.5rem;
}
</style>
@endsection
