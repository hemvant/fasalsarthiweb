@extends('expert.layout')
@section('title', 'Expert Registration')
@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header">Expert Registration</div>
            <div class="card-body">
                <p class="text-muted small mb-4">Complete your profile to join the expert community.</p>
                <form action="{{ route('expert.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $profile->user->name ?? '') }}" required>
                        @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $profile->qualification ?? '') }}" placeholder="e.g. B.Sc Agriculture" required>
                        @error('qualification')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience', $profile->experience ?? '') }}" placeholder="e.g. 10 years" required>
                        @error('experience')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $profile->specialization ?? '') }}" placeholder="e.g. Crop, Dairy, Soil" required>
                        @error('specialization')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Certificate (PDF or image)</label>
                        <input type="file" name="certificate" class="form-control @error('certificate') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                        @if($profile->certificate_path)<p class="small text-muted mt-1">Current file uploaded.</p>@endif
                        @error('certificate')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane me-1"></i> Submit Application</button>
                <a href="{{ route('expert.dashboard') }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
