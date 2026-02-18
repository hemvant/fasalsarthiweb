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
                Use the sidebar to manage your website content. More sections (schemes, crops, irrigation, blog, etc.)
                will appear here as we make the site dynamic.
            </p>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4 border-start border-4 border-success">
            <h6 class="text-muted text-uppercase small mb-2">Quick links</h6>
            <ul class="list-unstyled mb-0">
                <li class="mb-2"><a href="{{ url('/') }}" target="_blank" class="text-decoration-none">View homepage</a></li>
                <li class="mb-2"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
            </ul>
        </div>
    </div>
</div>
@endsection
