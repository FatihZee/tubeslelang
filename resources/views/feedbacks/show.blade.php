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
                                <h1 class="text-white mb-4">Feedback Details</h1>
                                
                                <!-- Feedback Details -->
                                <div class="details-container text-white mb-4">
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>User:</strong></div>
                                        <div class="col-md-8">{{ $feedback->user->name }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Transaction ID:</strong></div>
                                        <div class="col-md-8">{{ $feedback->transaction->id }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-4"><strong>Feedback:</strong></div>
                                        <div class="col-md-8">{{ $feedback->feedback }}</div>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="text-end mt-4">
                                    <a href="{{ route('feedbacks.index') }}" 
                                       class="btn rounded-pill btn-light btn-sm me-2 px-4">Back</a>
                                </div>
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

.details-container {
    background: rgba(255, 255, 255, 0.1);
    border-radius: 1em;
    padding: 1.5rem;
    margin-bottom: 2rem;
    background-image: url('{{ asset("bg.jpg") }}');
   
}

.details-container .row {
    margin: 0;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.details-container .row:last-child {
    border-bottom: none;
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
