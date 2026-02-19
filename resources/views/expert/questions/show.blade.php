@extends('expert.layout')
@section('title', 'Post')
@section('content')
<div class="mb-3">
    <a href="{{ route('expert.questions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Community</a>
</div>

{{-- Post card --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <div class="d-flex align-items-center">
                <span class="rounded-circle bg-success bg-opacity-25 d-inline-flex align-items-center justify-content-center me-2" style="width:44px;height:44px">👨‍🌾</span>
                <div>
                    <strong>{{ $post->user->name ?? 'Farmer' }}</strong>
                    <br><small class="text-muted">{{ $post->crop->title ?? 'Community' }} · {{ $post->problemCategory->name ?? '-' }} · {{ $post->created_at->diffForHumans() }}</small>
                </div>
            </div>
            @if($post->expert_replied)<span class="badge bg-success"><i class="fas fa-check-circle"></i> Expert replied</span>@endif
            @if($post->is_solved)<span class="badge bg-secondary">Solved</span>@endif
        </div>
        <p class="mb-2 text-dark">{{ $post->body }}</p>
        @if($post->images->count() > 0)
        <div class="d-flex gap-2 mb-3 flex-wrap">
            @foreach($post->images as $img)
            <a href="{{ asset('storage/' . $img->path) }}" target="_blank" rel="noopener"><img src="{{ asset('storage/' . $img->path) }}" alt="" class="rounded" style="max-height:180px;max-width:100%;object-fit:cover"></a>
            @endforeach
        </div>
        @endif
        {{-- Like, comment, save --}}
        <div class="d-flex flex-wrap gap-3 align-items-center pt-2 border-top">
            <form action="{{ route('expert.questions.like', $post) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm {{ $liked ? 'btn-danger' : 'btn-outline-secondary' }}"><i class="fas fa-heart"></i> {{ $post->likes_count }}</button>
            </form>
            <span class="btn btn-sm btn-outline-secondary disabled"><i class="fas fa-comment"></i> {{ $post->comments_count }}</span>
            @if($saved)
            <form action="{{ route('expert.questions.unsave', $post) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-bookmark"></i> Saved</button>
            </form>
            @else
            <form action="{{ route('expert.questions.save', $post) }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-success"><i class="far fa-bookmark"></i> Save</button>
            </form>
            @endif
        </div>
    </div>
</div>

{{-- Comments on post --}}
<div class="card shadow-sm border-0 rounded-3 mb-3" id="comments">
    <div class="card-header bg-white border-bottom"><strong>Comments ({{ $post->comments->count() }})</strong></div>
    <div class="card-body">
        @forelse($post->comments as $c)
        <div class="mb-3 pb-3 border-bottom">
            <strong>{{ $c->user->name ?? 'User' }}</strong> <small class="text-muted">{{ $c->created_at->diffForHumans() }}</small>
            <p class="mb-0 mt-1">{{ $c->body }}</p>
        </div>
        @empty
        <p class="text-muted mb-0">No comments yet.</p>
        @endforelse
        @if(!$post->comments_locked)
        <form action="{{ route('expert.questions.comments', $post) }}" method="POST" class="mt-3">
            @csrf
            <textarea name="body" class="form-control mb-2" rows="2" placeholder="Add a comment..." required maxlength="2000"></textarea>
            <button type="submit" class="btn btn-success btn-sm">Post comment</button>
        </form>
        @else
        <p class="text-muted small mb-0 mt-2">Comments are closed.</p>
        @endif
    </div>
</div>

{{-- Answers (expert replies) --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white border-bottom"><strong>Answers ({{ $post->answers->count() }})</strong></div>
    <div class="card-body">
        @forelse($post->answers as $answer)
        <div class="border rounded p-3 mb-3 {{ $answer->is_best_answer ? 'border-success border-2' : '' }}">
            <div class="d-flex justify-content-between align-items-start">
                <strong>{{ $answer->user->name ?? 'User' }}</strong>
                @if($answer->user->expertProfile ?? null)<span class="badge bg-success">Expert</span>@endif
                <small class="text-muted">{{ $answer->created_at->diffForHumans() }}</small>
            </div>
            <p class="mb-2 mt-2">{{ $answer->body }}</p>
            @if($answer->attachments->count() > 0)
            <div class="small">
                @foreach($answer->attachments as $att)
                <a href="{{ $att->url }}" target="_blank" rel="noopener" class="me-2">{{ $att->original_name ?? 'Attachment' }}</a>
                @endforeach
            </div>
            @endif
        </div>
        @empty
        <p class="text-muted mb-0">No answers yet. Be the first to help!</p>
        @endforelse

        {{-- Submit answer (expert) --}}
        <form action="{{ route('expert.questions.answer', $post) }}" method="POST" enctype="multipart/form-data" class="mt-3 pt-3 border-top">
            @csrf
            <label class="form-label">Your answer</label>
            <textarea name="body" class="form-control mb-2" rows="4" required minlength="20" placeholder="Write a helpful answer (min 20 characters)"></textarea>
            <input type="file" name="attachments[]" multiple accept=".pdf,image/*" class="form-control form-control-sm mb-2">
            <button type="submit" class="btn btn-success">Submit answer</button>
        </form>
    </div>
</div>

@if(!$post->is_solved)
<form action="{{ route('expert.questions.solved', $post) }}" method="POST" class="mb-3">
    @csrf
    <button type="submit" class="btn btn-outline-secondary btn-sm">Mark as solved</button>
</form>
@endif
@endsection
