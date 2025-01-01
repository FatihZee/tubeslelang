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
                                <h1 class="text-white mb-4">Edit Bid</h1>

                                <form action="{{ route('bids.update', ['auction' => $auction->id, 'bid' => $bid->id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Bid Price Input -->
                                    <div class="mb-4">
                                        <label for="bid_price" class="form-label text-white">Bid Price:</label>
                                        <input type="number" name="bid_price" id="bid_price" 
                                               class="form-control bg-light bg-opacity-25 text-white border-light" 
                                               value="{{ old('bid_price', $bid->bid_price) }}" 
                                               step="0.01" required>
                                    </div>

                                    <!-- Submit and Back Buttons -->
                                    <div class="text-end mt-4">
                                        <a href="{{ route('bids.index', $auction->id) }}" 
                                           class="btn btn-light btn-sm rounded-pill px-4 me-2">Back</a>
                                        <button type="submit" 
                                                class="btn btn-primary btn-sm rounded-pill px-4">Update Bid</button>
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
