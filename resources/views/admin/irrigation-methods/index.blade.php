@extends('admin.layout')

@section('title', 'Irrigation Methods')
@section('header', 'Irrigation Methods')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <form method="GET" class="d-flex gap-2">
            <select name="category" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="">All categories</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </form>
        <a href="{{ route('admin.irrigation-methods.create') }}" class="btn btn-admin">Add Method</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($methods as $m)
                        <tr>
                            <td>
                                @if($m->featured_image)
                                    <img src="{{ asset('storage/' . $m->featured_image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                @else
                                    —
                                @endif
                            </td>
                            <td>{{ $m->title }}</td>
                            <td>{{ $m->category->name ?? '—' }}</td>
                            <td>{{ $m->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('irrigation.show', $m->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                <a href="{{ route('admin.irrigation-methods.edit', $m) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.irrigation-methods.destroy', $m) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No irrigation methods yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($methods->hasPages())
            <div class="card-footer">{{ $methods->links() }}</div>
        @endif
    </div>
@endsection
