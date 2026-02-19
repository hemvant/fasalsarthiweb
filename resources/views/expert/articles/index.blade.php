@extends('expert.layout')
@section('title', 'My Articles')
@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h3 class="page-title mb-0">My Articles</h3>
    <a href="{{ route('expert.articles.create') }}" class="btn btn-success"><i class="fas fa-plus me-1"></i> New article</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header"><i class="fas fa-newspaper me-2"></i>Articles</div>
    <div class="card-body p-0">
        @if($articles->count() > 0)
        <div class="table-responsive">
            <table class="table table-expert mb-0">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Updated</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($articles as $art)
                    <tr>
                        <td><strong>{{ $art->title }}</strong></td>
                        <td>
                            @if($art->status === 'published')
                            <span class="badge bg-success">Published</span>
                            @elseif($art->status === 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                            @else
                            <span class="badge bg-secondary">{{ $art->status }}</span>
                            @endif
                        </td>
                        <td><small class="text-muted">{{ $art->updated_at->format('M j, Y') }}</small></td>
                        <td class="table-actions text-end">
                            <a href="{{ route('expert.articles.edit', $art) }}" class="btn btn-sm btn-outline-success">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-newspaper"></i></div>
            <p class="empty-title">No articles yet</p>
            <p class="mb-3">Write your first article to help farmers.</p>
            <a href="{{ route('expert.articles.create') }}" class="btn btn-success">New article</a>
        </div>
        @endif
    </div>
</div>
@if($articles->hasPages())
<div class="mt-3 d-flex justify-content-center">{{ $articles->links() }}</div>
@endif
@endsection
