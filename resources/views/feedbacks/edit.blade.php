@extends(Auth::user()->role === 'admin' ? 'layouts.app' : 'layouts.member')

@section('content')
<div class="container">
    <h1>Edit Feedback</h1>
    <form action="{{ route('feedbacks.update', $feedback->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="feedback" class="form-label">Feedback</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="5" required>{{ $feedback->feedback }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection