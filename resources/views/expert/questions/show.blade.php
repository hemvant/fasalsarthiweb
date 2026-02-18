@extends('expert.layout')
@section('title', 'Question')
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <p>{{ $post->body }}</p>
        <form action="{{ route('expert.questions.solved', $post) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-sm btn-success">Mark solved</button>
        </form>
    </div>
</div>
@foreach($post->answers as $answer)
<div class="card mb-2">
    <div class="card-body">{{ $answer->body }}</div>
</div>
@endforeach
<form action="{{ route('expert.questions.answer', $post) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <textarea name="body" class="form-control mb-2" rows="4" required></textarea>
    <input type="file" name="attachments[]" multiple>
    <button type="submit" class="btn btn-success">Submit answer</button>
</form>
<a href="{{ route('expert.questions.index') }}" class="btn btn-outline-secondary mt-2">Back</a>
@endsection
