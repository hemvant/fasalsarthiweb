@extends('admin.layout')

@section('title', 'Contact Messages')
@section('header', 'Contact Messages')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form method="GET" class="d-flex gap-2 align-items-center">
            <label class="form-label mb-0 small">Status</label>
            <select name="status" class="form-select form-select-sm" style="width: auto;" onchange="this.form.submit()">
                <option value="">All</option>
                @foreach(\App\Models\ContactMessage::statusOptions() as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $msg)
                        <tr class="{{ $msg->status === 'new' ? 'table-warning' : '' }}">
                            <td>{{ $msg->full_name }}</td>
                            <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                            <td>{{ Str::limit($msg->message, 60) }}</td>
                            <td>
                                <span class="badge bg-{{ $msg->status === 'new' ? 'warning' : ($msg->status === 'replied' ? 'success' : ($msg->status === 'archived' ? 'secondary' : 'info')) }} text-dark">
                                    {{ \App\Models\ContactMessage::statusOptions()[$msg->status] ?? $msg->status }}
                                </span>
                            </td>
                            <td>{{ $msg->created_at->format('M j, Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="btn btn-sm btn-admin">View / Action</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-4">No contact messages yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($messages->hasPages())
            <div class="card-footer">{{ $messages->links() }}</div>
        @endif
    </div>
@endsection
