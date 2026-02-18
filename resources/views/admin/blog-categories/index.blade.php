@extends('admin.layout')

@section('title', 'Blog Categories')
@section('header', 'Blog Categories')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted mb-0">Manage categories e.g. Crop Management, Pest Control, Water Management.</p>
        <a href="{{ route('admin.blog-categories.create') }}" class="btn btn-admin">Add Category</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Posts</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $cat)
                        <tr>
                            <td>{{ $cat->name }}</td>
                            <td><code>{{ $cat->slug }}</code></td>
                            <td>{{ $cat->sort_order }}</td>
                            <td>{{ $cat->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $cat->posts_count }}</td>
                            <td>
                                <a href="{{ route('admin.blog-categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                <form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No categories yet. <a href="{{ route('admin.blog-categories.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="card-footer">{{ $categories->links() }}</div>
        @endif
    </div>
@endsection
