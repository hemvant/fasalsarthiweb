@extends('expert.layout')
@section('title', 'Expert Portal')
@section('content')
<div class="text-center py-5">
    <h1 class="display-5 mb-3">Expert Portal</h1>
    <p class="lead text-muted mb-4">Share your expertise with farmers. Answer questions, write articles, and help the community.</p>
    <a href="{{ route('expert.login') }}" class="btn btn-success btn-lg">Join as Expert</a>
    <p class="mt-4 mb-0 small text-muted">
        <a href="#" id="expert-install-landing-link" class="text-decoration-none"><i class="fas fa-download me-1"></i>Install as app</a>
    </p>
</div>
@endsection
