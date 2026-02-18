@extends('expert.layout')
@section('title', 'Edit Article')
@section('content')
<h3 class="mb-3">Edit Article</h3>
<form action="{{ route('expert.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', $article->title) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="expert_article_category_id" class="form-select">
            <option value="">None</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ $article->expert_article_category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="body" class="form-control" rows="10">{{ old('body', $article->body) }}</textarea>
    </div>
    <div class="mb-3">
        <label class="form-label">Featured image</label>
        <input type="file" name="featured_image" class="form-control" accept="image/*">
    </div>
    <div class="mb-3">
        <label><input type="checkbox" name="publish" value="1" {{ $article->status === 'published' ? 'checked' : '' }}> Publish</label>
    </div>
    <button type="submit" class="btn btn-success">Update</button>
    <a href="{{ route('expert.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
</form>
@endsection
