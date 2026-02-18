@extends('admin.layout')
@section('title', 'Post #' . $post->id)
@section('header', 'Post Detail')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <p><strong>By:</strong> {{ $post->user->name ?? '-' }} | <strong>Crop:</strong> {{ $post->crop->title ?? '-' }} | <strong>Category:</strong> {{ $post->problemCategory->name ?? '-' }}</p>
        <p class="mb-2">{{ $post->body }}</p>
        <p class="small text-muted">Status: {{ $post->status }} | Featured: {{ $post->featured ? 'Yes' : 'No' }} | Comments locked: {{ $post->comments_locked ? 'Yes' : 'No' }} | Solved: {{ $post->is_solved ? 'Yes' : 'No' }}</p>
        <form action="{{ route('admin.community.posts.update', $post) }}" method="POST" class="d-inline-flex gap-2 flex-wrap align-items-center">
            @csrf
            @method('PUT')
            <select name="status" class="form-select form-select-sm" style="width:auto">
                <option value="active" {{ $post->status === 'active' ? 'selected' : '' }}>Active</option>
                <option value="hidden" {{ $post->status === 'hidden' ? 'selected' : '' }}>Hidden</option>
                <option value="deleted" {{ $post->status === 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
            <label class="d-inline"><input type="checkbox" name="featured" value="1" {{ $post->featured ? 'checked' : '' }}> Featured</label>
            <label class="d-inline"><input type="checkbox" name="comments_locked" value="1" {{ $post->comments_locked ? 'checked' : '' }}> Lock comments</label>
            <button type="submit" class="btn btn-sm btn-admin">Update</button>
        </form>
        <form action="{{ route('admin.community.posts.destroy', $post) }}" method="POST" class="d-inline ms-2" onsubmit="return confirm('Delete this post?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
    </div>
</div>
<h6>Answers</h6>
@foreach($post->answers as $answer)
<div class="card mb-2">
    <div class="card-body py-2">
        <p class="mb-1">{{ $answer->body }}</p>
        <p class="small text-muted mb-1">By {{ $answer->user->name ?? '-' }} @if($answer->isFromExpert()) <span class="badge bg-info">Expert</span> @endif | Pinned: {{ $answer->is_pinned ? 'Yes' : 'No' }} | Best: {{ $answer->is_best_answer ? 'Yes' : 'No' }}</p>
        <div class="d-flex gap-1">
            <form action="{{ route('admin.community.answers.pin', $answer) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-secondary">Pin</button></form>
            <form action="{{ route('admin.community.answers.unpin', $answer) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-secondary">Unpin</button></form>
            <form action="{{ route('admin.community.answers.best', $answer) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-success">Mark best</button></form>
            <form action="{{ route('admin.community.answers.destroy', $answer) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this answer?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
        </div>
    </div>
</div>
@endforeach
<a href="{{ route('admin.community.posts.index') }}" class="btn btn-outline-secondary">Back to list</a>
@endsection
