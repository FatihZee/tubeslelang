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
                                <h1 class="text-white mb-4">Edit Transaction</h1>

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

                                <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <!-- User Selection -->
                                    <div class="mb-4">
                                        <label for="user_id" class="form-label text-white">User</label>
                                        <select name="user_id" id="user_id" 
                                                class="form-select bg-light bg-opacity-25 text-white border-light">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id_user }}" 
                                                        {{ $transaction->user_id == $user->id_user ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Bid Selection -->
                                    <div class="mb-4">
                                        <label for="bid_id" class="form-label text-white">Bid</label>
                                        <select name="bid_id" id="bid_id" 
                                                class="form-select bg-light bg-opacity-25 text-white border-light">
                                            @foreach ($bids as $bid)
                                                <option value="{{ $bid->id }}" 
                                                        {{ $transaction->bid_id == $bid->id ? 'selected' : '' }}>
                                                    {{ $bid->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Nominal Input -->
                                    <div class="mb-4">
                                        <label for="nominal" class="form-label text-white">Nominal</label>
                                        <input type="number" name="nominal" id="nominal" 
                                               value="{{ old('nominal', $transaction->nominal) }}" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               min="0" required>
                                    </div>

                                    <!-- Image Input -->
                                    <div class="mb-4">
                                        <label for="image" class="form-label text-white">Image</label>
                                        <input type="file" name="image" id="image" class="form-control bg-light bg-opacity-25 text-white border-light">
                                        @if ($transaction->image)
                                            <img src="{{ asset('storage/' . $transaction->image) }}" alt="Transaction Image" class="img-thumbnail mt-2" style="width: 200px;">
                                        @endif
                                    </div>

                                    <!-- Status Selection -->
                                    <div class="mb-4">
                                        <label for="status" class="form-label text-white">Status</label>
                                        <select name="status" id="status" 
                                                class="form-select bg-light bg-opacity-25 text-white border-light custom-dropdown">
                                            <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="confirmed" {{ $transaction->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                            <option value="rejected" {{ $transaction->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        </select>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="text-end mt-4">
                                        <a href="javascript:history.back()" 
                                           class="btn btn-light btn-sm rounded-pill px-4 me-2">Back</a>
                                        <button type="submit" 
                                                class="btn btn-primary btn-sm rounded-pill px-4">Update Transaction</button>
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

.form-select, .form-control {
    background-color: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white !important;
    transition: all 0.3s ease;
}

.form-select:focus, .form-control:focus {
    background-color: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(255, 255, 255, 0.3);
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.1);
}

.custom-dropdown option {
    background-color: rgba(0, 0, 0, 0.8);
    color: white;
    backdrop-filter: blur(5px);
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

</style>

@endsection