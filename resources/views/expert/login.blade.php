@extends('expert.layout')
@section('title', 'Expert Login')
@section('content')
<div class="row justify-content-center py-4">
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h4 class="page-title mb-2">Expert Login</h4>
                <p class="text-muted small mb-4">Only Google sign-in is allowed for experts.</p>
                <a href="{{ route('expert.auth.google') }}" class="btn btn-success w-100 d-flex align-items-center justify-content-center gap-2 py-3">
                    <i class="fab fa-google fa-lg"></i> Continue with Google
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
