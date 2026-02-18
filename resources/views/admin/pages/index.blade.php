@extends('admin.layout')

@section('title', 'Terms & Privacy')
@section('header', 'Terms & Privacy')

@section('content')
    <p class="text-muted mb-3">Edit site-wide legal and policy pages. Content supports HTML.</p>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Page</th>
                        <th>Slug</th>
                        <th>Updated</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pages as $p)
                        <tr>
                            <td>{{ $p->title }}</td>
                            <td><code>{{ $p->slug }}</code></td>
                            <td>{{ $p->updated_at->format('M j, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.pages.edit', $p) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                <a href="{{ $p->slug == 'terms' ? route('term') : route('privacy') }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
