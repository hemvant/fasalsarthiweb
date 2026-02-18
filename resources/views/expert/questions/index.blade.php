@extends('expert.layout')
@section('title', 'Questions')
@section('content')
<h3 class="mb-3">Answer Questions</h3>
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-3">
        <select name="crop_id" class="form-select">
            <option value="">All crops</option>
            @foreach($crops as $c)
            <option value="{{ $c->id }}" {{ request('crop_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="problem_category_id" class="form-select">
            <option value="">All categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('problem_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2"><button type="submit" class="btn btn-success">Filter</button></div>
</form>
<div class="list-group">
    @forelse($questions as $q)
    <a href="{{ route('expert.questions.show', $q) }}" class="list-group-item list-group-item-action">
        <strong>{{ Str::limit($q->body, 80) }}</strong>
        <br><small class="text-muted">{{ $q->user->name ?? '-' }} · {{ $q->crop->title ?? '-' }} · {{ $q->problemCategory->name ?? '-' }}</small>
    </a>
    @empty
    <p class="text-muted">No unsolved questions match your filters.</p>
    @endforelse
</div>
@if($questions->hasPages())<div class="mt-3">{{ $questions->links() }}</div>@endif
@endsection
