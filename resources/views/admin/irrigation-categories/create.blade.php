@extends('admin.layout')

@section('title', 'Add Irrigation Category')
@section('header', 'Add Irrigation Category')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.irrigation-categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Name *</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="e.g. Drip">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug (URL)</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="drip">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort Order</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="form-check-label">Active</label>
                </div>
                <button type="submit" class="btn btn-admin">Create Category</button>
                <a href="{{ route('admin.irrigation-categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection
