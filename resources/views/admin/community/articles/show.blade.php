@extends('admin.layout')
@section('title', $article->title)
@section('header', 'Article')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h5>{{ $article->title }}</h5>
        <p class="text-muted">By {{ $article->user->name ?? '-' }} | Category: {{ $article->category->name ?? '-' }} | Status: {{ $article->status }} | Featured: {{ $article->featured ? 'Yes' : 'No' }}</p>
        <div class="border rounded p-3 bg-light">{!! Str::limit(strip_tags($article->body), 500) !!}</div>
        <div class="mt-3">
            @if($article->status !== 'published')
            <form action="{{ route('admin.community.articles.approve', $article) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-success">Approve & Publish</button></form>
            @endif
            <form action="{{ route('admin.community.articles.feature', $article) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-outline-info">{{ $article->featured ? 'Unfeature' : 'Feature' }}</button></form>
            <form action="{{ route('admin.community.articles.destroy', $article) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?');">@csrf @method('DELETE')<button type="submit" class="btn btn-outline-danger">Delete</button></form>
        </div>
    </div>
</div>
<a href="{{ route('admin.community.articles.index') }}" class="btn btn-outline-secondary">Back to list</a>
@endsection
