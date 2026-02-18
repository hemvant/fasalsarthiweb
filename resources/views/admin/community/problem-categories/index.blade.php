@extends('admin.layout')
@section('title', 'Problem Categories')
@section('header', 'Problem Categories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="text-muted mb-0">Categories for community posts.</p>
    <a href="{{ route('admin.community.problem-categories.create') }}" class="btn btn-admin">Add Category</a>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>{{ $cat->name }}</td>
                    <td><code>{{ $cat->slug }}</code></td>
                    <td>{{ $cat->sort_order }}</td>
                    <td>{{ $cat->is_active ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.community.problem-categories.edit', $cat) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                        <form action="{{ route('admin.community.problem-categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No categories. <a href="{{ route('admin.community.problem-categories.create') }}">Add one</a>.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())<div class="card-footer">{{ $categories->links() }}</div>@endif
</div>
@endsection
