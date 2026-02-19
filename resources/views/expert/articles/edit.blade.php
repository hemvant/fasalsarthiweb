@extends('expert.layout')
@section('title', 'Edit Article')
@section('content')
<div class="mb-3">
    <a href="{{ route('expert.articles.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Articles</a>
</div>
<h3 class="page-title">Edit Article</h3>

<div class="card border-0 shadow-sm">
    <div class="card-body">
<form action="{{ route('expert.articles.update', $article) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $article->title) }}" required>
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Category</label>
        <select name="expert_article_category_id" class="form-select @error('expert_article_category_id') is-invalid @enderror">
            <option value="">None</option>
            @foreach($categories as $c)
            <option value="{{ $c->id }}" {{ old('expert_article_category_id', $article->expert_article_category_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
        @error('expert_article_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="10">{{ old('body', $article->body) }}</textarea>
        @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Featured image</label>
        <input type="file" name="featured_image" class="form-control @error('featured_image') is-invalid @enderror" accept="image/*">
        @if($article->featured_image_path ?? null)<p class="small text-muted mt-1">Current image uploaded.</p>@endif
        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <div class="form-check">
            <input type="checkbox" name="publish" value="1" id="publish" class="form-check-input" {{ old('publish', $article->status === 'published') ? 'checked' : '' }}>
            <label class="form-check-label" for="publish">Publish</label>
        </div>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Update</button>
    <a href="{{ route('expert.articles.index') }}" class="btn btn-outline-secondary">Cancel</a>
</form>
    </div>
</div>
@endsection
