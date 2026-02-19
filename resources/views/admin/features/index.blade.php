@extends('admin.layout')

@section('title', 'Features')
@section('header', 'Features')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <p class="text-muted small mb-0">Manage website features (listing and detail pages).</p>
        <a href="{{ route('admin.features.create') }}" class="btn btn-admin">Add Feature</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($features as $f)
                        <tr>
                            <td>
                                @if($f->icon)
                                    <span class="feature-icon {{ $f->icon_class }}" style="width:36px;height:36px;border-radius:8px;display:inline-flex;align-items:center;justify-content:center;"><i class="fas {{ $f->icon }}"></i></span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $f->title }}</td>
                            <td><code>{{ $f->slug }}</code></td>
                            <td>{{ $f->sort_order }}</td>
                            <td>{{ $f->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('feature.show', $f->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                <a href="{{ route('admin.features.edit', $f) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.features.destroy', $f) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this feature?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No features yet. <a href="{{ route('admin.features.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($features->hasPages())
            <div class="card-footer">{{ $features->links() }}</div>
        @endif
    </div>
@endsection
