@extends('expert.layout')
@section('title', 'New Article')
@section('content')
<h3>New Article</h3>
<form action="{{ route('expert.articles.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label>Title</label>
    <input type="text" name="title" class="form-control" required>
    <label>Category</label>
    <select name="expert_article_category_id" class="form-select">
        <option value="">None</option>
        @foreach($categories as $c)
        <option value="{{ $c->id }}">{{ $c->name }}</option>
        @endforeach
    </select>
    <label>Content</label>
    <textarea name="body" class="form-control" rows="10"></textarea>
    <label>Featured image</label>
    <input type="file" name="featured_image" accept="image/*">
    <label><input type="checkbox" name="publish" value="1"> Publish</label>
    <button type="submit" class="btn btn-success">Save</button>
    <a href="{{ route('expert.articles.index') }}">Cancel</a>
</form>
@endsection
