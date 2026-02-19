@extends('expert.layout')
@section('title', 'Community')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h3 class="page-title mb-0">Community</h3>
    <a href="{{ route('expert.questions.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> New post</a>
</div>

{{-- Category / filter tabs --}}
<div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
    <a href="{{ route('expert.questions.index') }}" class="btn btn-sm {{ !request('problem_category_id') && !request('unsolved') ? 'btn-success' : 'btn-outline-success' }}">All Posts</a>
    @foreach($categories as $cat)
    <a href="{{ route('expert.questions.index', ['problem_category_id' => $cat->id]) }}" class="btn btn-sm {{ request('problem_category_id') == $cat->id ? 'btn-success' : 'btn-outline-success' }}">{{ $cat->name }}</a>
    @endforeach
    <a href="{{ route('expert.questions.index', ['unsolved' => 1]) }}" class="btn btn-sm {{ request('unsolved') ? 'btn-warning' : 'btn-outline-warning' }}">Unsolved only</a>
</div>

{{-- Optional crop filter --}}
<form method="GET" class="row g-2 mb-3">
    @if(request('problem_category_id'))<input type="hidden" name="problem_category_id" value="{{ request('problem_category_id') }}">@endif
    @if(request('unsolved'))<input type="hidden" name="unsolved" value="1">@endif
    <div class="col-auto">
        <select name="crop_id" class="form-select form-select-sm" style="width:auto">
            <option value="">All crops</option>
            @foreach($crops as $c)
            <option value="{{ $c->id }}" {{ request('crop_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-auto"><button type="submit" class="btn btn-sm btn-success">Filter</button></div>
</form>

<div class="list-group list-group-flush">
    @forelse($questions as $q)
    <div class="card shadow-sm mb-3 border-0 overflow-hidden">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
                <div class="d-flex align-items-center">
                    <span class="rounded-circle bg-success bg-opacity-25 d-inline-flex align-items-center justify-content-center me-2" style="width:40px;height:40px">👨‍🌾</span>
                    <div>
                        <strong>{{ $q->user->name ?? 'Farmer' }}</strong>
                        <br><small class="text-muted">{{ $q->crop->title ?? 'Community' }} · {{ $q->problemCategory->name ?? '-' }}@if($q->expert_replied) · <i class="fas fa-check-circle text-success"></i>@endif</small>
                    </div>
                </div>
                <span class="badge bg-secondary">{{ $q->created_at->diffForHumans() }}</span>
            </div>
            <p class="mb-2 text-dark">{{ Str::limit($q->body, 200) }}</p>
            @if($q->images->count() > 0)
            <div class="d-flex gap-1 mb-2 flex-wrap">
                @foreach($q->images->take(3) as $img)
                <img src="{{ asset('storage/' . $img->path) }}" alt="" class="rounded" style="height:80px;width:80px;object-fit:cover">
                @endforeach
            </div>
            @endif
            <div class="d-flex flex-wrap gap-3 align-items-center pt-2 border-top">
                <form action="{{ route('expert.questions.like', $q) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-decoration-none p-0 {{ isset($likedIds[$q->id]) ? 'text-danger' : 'text-muted' }}">
                        <i class="fas fa-heart"></i> {{ $q->likes_count }}
                    </button>
                </form>
                <a href="{{ route('expert.questions.show', $q) }}#comments" class="btn btn-sm btn-link text-muted text-decoration-none p-0"><i class="fas fa-comment"></i> {{ $q->comments_count }}</a>
                @if(isset($savedIds[$q->id]))
                <form action="{{ route('expert.questions.unsave', $q) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-success text-decoration-none p-0"><i class="fas fa-bookmark"></i> Saved</button>
                </form>
                @else
                <form action="{{ route('expert.questions.save', $q) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-link text-muted text-decoration-none p-0"><i class="far fa-bookmark"></i> Save</button>
                </form>
                @endif
                <a href="{{ route('expert.questions.show', $q) }}" class="btn btn-sm btn-success ms-auto">View & reply</a>
            </div>
        </div>
    </div>
    @empty
<div class="card border-0 shadow-sm">
    <div class="empty-state">
        <div class="empty-icon"><i class="fas fa-users"></i></div>
        <p class="empty-title">No posts found</p>
        <p class="mb-0">Change filters or check back later.</p>
    </div>
</div>
    @endforelse
</div>
@if($questions->hasPages())
<div class="mt-3 d-flex justify-content-center">{{ $questions->links() }}</div>
@endif
@endsection
