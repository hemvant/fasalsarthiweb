@extends('admin.layout')
@section('title', 'Community Posts')
@section('header', 'Community Posts')

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Body</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->user->name ?? '-' }}</td>
                    <td>{{ Str::limit($post->body, 40) }}</td>
                    <td>{{ $post->status }}</td>
                    <td>
                        <a href="{{ route('admin.community.posts.show', $post) }}" class="btn btn-sm btn-admin">View</a>
                        <form action="{{ route('admin.community.posts.destroy', $post) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">No posts.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())<div class="card-footer">{{ $posts->links() }}</div>@endif
</div>
@endsection
