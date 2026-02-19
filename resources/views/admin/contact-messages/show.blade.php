@extends('admin.layout')

@section('title', 'Contact: ' . $contact->full_name)
@section('header', 'Contact Message')

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3">
                        <h5 class="card-title mb-0">{{ $contact->full_name }}</h5>
                        <span class="badge bg-{{ $contact->status === 'new' ? 'warning' : ($contact->status === 'replied' ? 'success' : ($contact->status === 'archived' ? 'secondary' : 'info')) }} text-dark">
                            {{ \App\Models\ContactMessage::statusOptions()[$contact->status] ?? $contact->status }}
                        </span>
                    </div>
                    <p class="text-muted small mb-2"><i class="fas fa-envelope me-1"></i> <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a></p>
                    @if($contact->phone)<p class="text-muted small mb-2"><i class="fas fa-phone me-1"></i> {{ $contact->phone }}</p>@endif
                    <p class="text-muted small mb-0"><i class="fas fa-clock me-1"></i> {{ $contact->created_at->format('M j, Y H:i') }}</p>
                    <hr>
                    <h6 class="text-dark">Message</h6>
                    <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-light"><strong>Take action</strong></div>
                <div class="card-body">
                    <form action="{{ route('admin.contact-messages.update', $contact) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select" required>
                                @foreach(\App\Models\ContactMessage::statusOptions() as $value => $label)
                                    <option value="{{ $value }}" {{ old('status', $contact->status) === $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Admin notes</label>
                            <textarea name="admin_notes" class="form-control" rows="4" placeholder="Internal notes (not sent to user)">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-admin w-100">Save</button>
                    </form>
                    @if($contact->replied_at)
                        <p class="small text-muted mt-2 mb-0"><i class="fas fa-check me-1"></i> Marked replied {{ $contact->replied_at->format('M j, Y') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="mt-2">
        <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left me-1"></i> Back to list</a>
    </div>
@endsection
