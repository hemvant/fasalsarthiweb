@extends('admin.layout')
@section('title', 'Expert Articles')
@section('header', 'Expert Articles')

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Featured</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $art)
                <tr>
                    <td>{{ Str::limit($art->title, 50) }}</td>
                    <td>{{ $art->user->name ?? '-' }}</td>
                    <td>{{ $art->category->name ?? '-' }}</td>
                    <td><span class="badge bg-{{ $art->status === 'published' ? 'success' : 'secondary' }}">{{ $art->status }}</span></td>
                    <td>{{ $art->featured ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.community.articles.show', $art) }}" class="btn btn-sm btn-admin">View</a>
                        @if($art->status !== 'published')
                        <form action="{{ route('admin.community.articles.approve', $art) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Approve</button></form>
                        @endif
                        <form action="{{ route('admin.community.articles.feature', $art) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-info">{{ $art->featured ? 'Unfeature' : 'Feature' }}</button></form>
                        <form action="{{ route('admin.community.articles.destroy', $art) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No articles.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($articles->hasPages())<div class="card-footer">{{ $articles->links() }}</div>@endif
</div>
@endsection
