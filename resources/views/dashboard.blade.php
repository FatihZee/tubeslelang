@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
    <div class="container mt-4">
        <img src="{{ asset('dashboard.jpg') }}" class="img-fluid" alt="Dashboard Image">
    </div>
@endsection
