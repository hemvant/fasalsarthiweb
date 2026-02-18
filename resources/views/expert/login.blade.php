@extends('expert.layout')
@section('title', 'Expert Login')
@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-body p-4">
                <h4 class="card-title mb-4">Expert Login</h4>
                <p class="text-muted small">Only Google sign-in is allowed for experts.</p>
                <a href="{{ route('expert.auth.google') }}" class="btn btn-outline-danger d-flex align-items-center justify-content-center gap-2">
                    <i class="fab fa-google"></i> Continue with Google
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
