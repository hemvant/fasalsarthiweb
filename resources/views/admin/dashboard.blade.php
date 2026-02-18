@extends('admin.layout')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-12">
        <div class="card p-4">
            <h4 class="text-success mb-3">
                <i class="fas fa-check-circle me-2"></i> Welcome to Admin Panel
            </h4>
            <p class="text-muted mb-0">
                You are logged in as <strong>{{ auth()->guard('admin')->user()->name }}</strong>.
                Use the sidebar to manage your website and the Farmer Community.
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 border-start border-4 border-primary">
            <h6 class="text-muted text-uppercase small mb-2">Community Overview</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><strong>{{ $totalFarmers }}</strong> Farmers (users)</li>
                <li class="mb-2"><strong>{{ $totalExperts }}</strong> Experts</li>
                <li class="mb-2"><strong class="text-warning">{{ $pendingExperts }}</strong> Pending expert approvals</li>
                <li class="mb-2"><strong>{{ $totalPosts }}</strong> Posts</li>
                <li class="mb-2"><strong>{{ $totalAnswers }}</strong> Answers</li>
                <li class="mb-2"><strong class="text-danger">{{ $reportedPosts }}</strong> Pending reports</li>
            </ul>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 border-start border-4 border-success">
            <h6 class="text-muted text-uppercase small mb-2">Quick links</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="{{ url('/') }}" target="_blank" class="text-decoration-none">View homepage</a></li>
                @if($pendingExperts > 0)
                <li class="mb-2"><a href="{{ route('admin.community.experts.index') }}?status=pending" class="text-decoration-none">Review pending experts</a></li>
                @endif
                @if($reportedPosts > 0)
                <li class="mb-2"><a href="{{ route('admin.community.reports.index') }}" class="text-decoration-none">Review reports</a></li>
                @endif
            </ul>
        </div>
    </div>
</div>
@endsection
