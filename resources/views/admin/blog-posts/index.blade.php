@extends('admin.layout')

@section('title', 'Blog Posts')
@section('header', 'Blog Posts')

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
        <a href="{{ route('admin.blog-posts.create') }}" class="btn btn-admin">Add Post</a>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Published</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                        <tr>
                            <td>
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->category->name ?? '—' }}</td>
                            <td>{{ $post->published_at ? $post->published_at->format('M j, Y') : '—' }}</td>
                            <td>{{ $post->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                                <a href="{{ route('admin.blog-posts.edit', $post) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <form action="{{ route('admin.blog-posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No posts yet. <a href="{{ route('admin.blog-posts.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="card-footer">{{ $posts->links() }}</div>
        @endif
    </div>
@endsection
