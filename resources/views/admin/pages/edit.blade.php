@extends('admin.layout')

@section('title', 'Edit Page')
@section('header', 'Edit Page')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $page->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Content (HTML allowed)</label>
                    <textarea name="content" class="form-control summernote" rows="18">{{ old('content', $page->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta Description</label>
                    <textarea name="meta_description" class="form-control summernote" rows="2" maxlength="500">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>
                <button type="submit" class="btn btn-admin">Update Page</button>
                <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
