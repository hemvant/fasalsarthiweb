@extends('admin.layout')
@section('title', 'Expert Profile')
@section('header', 'Expert Profile')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <h5>{{ $expert->user->name ?? 'N/A' }}</h5>
                <p class="text-muted">{{ $expert->user->email ?? '' }}</p>
                <p>Qualification: {{ $expert->qualification ?? '-' }}</p>
                <p>Experience: {{ $expert->experience ?? '-' }}</p>
                <p>Specialization: {{ $expert->specialization ?? '-' }}</p>
                <p>Status: <span class="badge bg-success">{{ $expert->status }}</span> @if($expert->verified) <span class="badge bg-info">Verified</span> @endif</p>
                @if($expert->certificate_path)
                <p><a href="{{ $expert->certificate_url }}" target="_blank" class="btn btn-sm btn-outline-primary">View Certificate</a></p>
                @endif
                @if($expert->admin_notes)<p class="small text-muted">Notes: {{ $expert->admin_notes }}</p>@endif
            </div>
        </div>
        <form action="{{ route('admin.community.experts.notes', ['expert_profile' => $expert]) }}" method="POST" class="card mb-3">
            @csrf
            @method('PUT')
            <div class="card-body">
                <label class="form-label">Admin notes</label>
                <textarea name="admin_notes" class="form-control" rows="2">{{ $expert->admin_notes }}</textarea>
                <button type="submit" class="btn btn-admin mt-2">Save</button>
            </div>
        </form>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                @if($expert->status === 'pending')
                <form action="{{ route('admin.community.experts.approve', ['expert_profile' => $expert]) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-success w-100 mb-2">Approve</button></form>
                <form action="{{ route('admin.community.experts.reject', ['expert_profile' => $expert]) }}" method="POST" class="d-inline">
                    @csrf
                    <input type="text" name="admin_notes" class="form-control mb-2" placeholder="Rejection reason">
                    <button type="submit" class="btn btn-danger w-100">Reject</button>
                </form>
                @endif
                @if($expert->status === 'approved')
                <form action="{{ route('admin.community.experts.suspend', ['expert_profile' => $expert]) }}" method="POST" class="mb-2">
                    @csrf
                    <input type="text" name="admin_notes" class="form-control mb-2" placeholder="Reason">
                    <button type="submit" class="btn btn-warning w-100">Suspend</button>
                </form>
                <form action="{{ route('admin.community.experts.toggle-verification', ['expert_profile' => $expert]) }}" method="POST" class="mb-2">@csrf<button type="submit" class="btn btn-outline-info w-100">Toggle verification</button></form>
                @endif
                @if($expert->status === 'suspended' || $expert->suspended_at)
                <form action="{{ route('admin.community.experts.unsuspend', ['expert_profile' => $expert]) }}" method="POST">@csrf<button type="submit" class="btn btn-success w-100">Unsuspend</button></form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
