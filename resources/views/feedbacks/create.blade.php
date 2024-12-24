@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container">
    <h1>Submit Feedback</h1>
    <form action="{{ route('feedbacks.store') }}" method="POST">
        @csrf
        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
        <div class="mb-3">
            <label for="feedback" class="form-label">Feedback</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
