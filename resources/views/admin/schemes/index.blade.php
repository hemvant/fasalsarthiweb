@extends('admin.layout')

@section('title', 'Schemes')
@section('header', 'Schemes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" class="d-flex gap-2">
            <select name="category" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.schemes.create') }}" class="btn btn-admin">Add Scheme</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schemes as $scheme)
                        <tr>
                            <td>
                                @if($scheme->featured_image)
                                    <img src="{{ asset('storage/' . $scheme->featured_image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $scheme->title }}</td>
                            <td>{{ $scheme->category->name ?? '—' }}</td>
                            <td>{{ $scheme->deadline ?? '—' }}</td>
                            <td>{{ $scheme->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('scheme.show', $scheme->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                <a href="{{ route('admin.schemes.edit', $scheme) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.schemes.destroy', $scheme) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this scheme?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No schemes yet. <a href="{{ route('admin.schemes.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($schemes->hasPages())
            <div class="card-footer">{{ $schemes->links() }}</div>
        @endif
    </div>
@endsection
