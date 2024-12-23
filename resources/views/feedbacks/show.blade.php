@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container">
    <h1>Feedback Details</h1>
    <p><strong>User:</strong> {{ $feedback->user->name }}</p>
    <p><strong>Transaction ID:</strong> {{ $feedback->transaction->id }}</p>
    <p><strong>Feedback:</strong></p>
    <p>{{ $feedback->feedback }}</p>
</div>
@endsection 