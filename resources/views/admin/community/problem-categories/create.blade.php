@extends('admin.layout')
@section('title', 'Add Problem Category')
@section('header', 'Add Problem Category')

@section('content')
<form action="{{ route('admin.community.problem-categories.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Sort order</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}">
            </div>
            <div class="mb-3">
                <label><input type="checkbox" name="is_active" value="1" checked> Active</label>
            </div>
            <button type="submit" class="btn btn-admin">Create</button>
            <a href="{{ route('admin.community.problem-categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </div>
</form>
@endsection
