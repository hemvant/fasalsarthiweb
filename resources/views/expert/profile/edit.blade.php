@extends('expert.layout')
@section('title', 'Profile')
@section('content')
<h3 class="page-title">Expert Profile</h3>
<p class="page-subtitle">Update your public profile visible to farmers.</p>

<div class="card border-0 shadow-sm">
    <div class="card-body">
<form action="{{ route('expert.profile.update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Qualification <span class="text-danger">*</span></label>
        <input type="text" name="qualification" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $profile->qualification) }}" placeholder="e.g. B.Sc Agriculture" required>
        @error('qualification')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Experience <span class="text-danger">*</span></label>
        <input type="text" name="experience" class="form-control @error('experience') is-invalid @enderror" value="{{ old('experience', $profile->experience) }}" placeholder="e.g. 10 years" required>
        @error('experience')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-3">
        <label class="form-label">Specialization <span class="text-danger">*</span></label>
        <input type="text" name="specialization" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $profile->specialization) }}" placeholder="e.g. Crop, Dairy, Soil" required>
        @error('specialization')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="mb-4">
        <div class="form-check">
            <input type="checkbox" name="availability" value="1" id="availability" class="form-check-input" {{ old('availability', $profile->availability) ? 'checked' : '' }}>
            <label class="form-check-label" for="availability">Available (online)</label>
        </div>
    </div>
    <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Update profile</button>
</form>
    </div>
</div>
@endsection
