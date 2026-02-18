@extends('admin.layout')
@section('title', 'Community Experts')
@section('header', 'Community Experts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="{{ route('admin.community.experts.index') }}" class="btn btn-sm btn-outline-secondary">All</a>
        <a href="{{ route('admin.community.experts.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-warning">Pending</a>
        <a href="{{ route('admin.community.experts.index', ['status' => 'approved']) }}" class="btn btn-sm btn-outline-success">Approved</a>
    </div>
</div>
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Qualification</th>
                    <th>Status</th>
                    <th>Verified</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($experts as $expert)
                <tr>
                    <td>{{ $expert->user->name ?? '-' }}</td>
                    <td>{{ $expert->user->email ?? '-' }}</td>
                    <td>{{ $expert->qualification ?? '-' }}</td>
                    <td><span class="badge bg-{{ $expert->status === 'approved' ? 'success' : ($expert->status === 'pending' ? 'warning' : 'secondary') }}">{{ $expert->status }}</span></td>
                    <td>{{ $expert->verified ? 'Yes' : 'No' }}</td>
                    <td><a href="{{ route('admin.community.experts.show', ['expert_profile' => $expert]) }}" class="btn btn-sm btn-admin">View</a></td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">No experts found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($experts->hasPages())<div class="card-footer">{{ $experts->links() }}</div>@endif
</div>
@endsection
