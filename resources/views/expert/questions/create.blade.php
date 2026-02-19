@extends('expert.layout')
@section('title', 'New post')
@section('content')
<div class="mb-3">
    <a href="{{ route('expert.questions.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fas fa-arrow-left me-1"></i> Back to Community</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <h4 class="page-title mb-4">Share with Community</h4>

        <form action="{{ route('expert.questions.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Category <span class="text-danger">*</span></label>
                <select name="problem_category_id" class="form-select @error('problem_category_id') is-invalid @enderror" required>
                    <option value="">Choose category</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('problem_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('problem_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Crop (optional)</label>
                <select name="crop_id" class="form-select @error('crop_id') is-invalid @enderror">
                    <option value="">None</option>
                    @foreach($crops as $c)
                    <option value="{{ $c->id }}" {{ old('crop_id') == $c->id ? 'selected' : '' }}>{{ $c->title }}</option>
                    @endforeach
                </select>
                @error('crop_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">What would you like to share? <span class="text-danger">*</span></label>
                <textarea name="body" class="form-control @error('body') is-invalid @enderror" rows="5" required minlength="20" maxlength="5000" placeholder="Write your post (at least 20 characters)...">{{ old('body') }}</textarea>
                <small class="text-muted">Min 20 characters, max 5000.</small>
                @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Images (optional, max 3)</label>
                <input type="file" name="images[]" accept="image/*" multiple class="form-control @error('images.*') is-invalid @enderror">
                <small class="text-muted">JPG, PNG, etc. Max 5MB each.</small>
                @error('images.*')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-1"></i> Share post</button>
            <a href="{{ route('expert.questions.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
