@extends('expert.layout')
@section('title', 'Expert Registration')
@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-header bg-success text-white">Expert Registration</div>
            <div class="card-body">
                <form action="{{ route('expert.register.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $profile->user->name ?? '') }}" required>
                        @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Qualification</label>
                        <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $profile->qualification ?? '') }}" placeholder="e.g. B.Sc Agriculture" required>
                        @error('qualification')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Experience</label>
                        <input type="text" name="experience" class="form-control" value="{{ old('experience', $profile->experience ?? '') }}" placeholder="e.g. 10 years" required>
                        @error('experience')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $profile->specialization ?? '') }}" placeholder="e.g. Crop, Dairy, Soil" required>
                        @error('specialization')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Certificate (PDF or image)</label>
                        <input type="file" name="certificate" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                        @if($profile->certificate_path)<p class="small text-muted mt-1">Current file uploaded.</p>@endif
                        @error('certificate')<div class="text-danger small">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-success">Submit Application</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
