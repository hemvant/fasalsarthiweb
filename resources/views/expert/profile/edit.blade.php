@extends('expert.layout')
@section('title', 'Profile')
@section('content')
<h3 class="mb-3">Expert Profile</h3>
<form action="{{ route('expert.profile.update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Qualification</label>
        <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $profile->qualification) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Experience</label>
        <input type="text" name="experience" class="form-control" value="{{ old('experience', $profile->experience) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Specialization</label>
        <input type="text" name="specialization" class="form-control" value="{{ old('specialization', $profile->specialization) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-check"><input type="checkbox" name="availability" value="1" {{ old('availability', $profile->availability) ? 'checked' : '' }}> Available (online)</label>
    </div>
    <button type="submit" class="btn btn-success">Update profile</button>
</form>
@endsection
