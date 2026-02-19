@extends('admin.layout')

@section('title', 'Newsletter Subscribers')
@section('header', 'Newsletter Subscribers')

@section('content')
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Subscribed</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscribers as $s)
                        <tr>
                            <td>{{ $s->email }}</td>
                            <td>{{ $s->subscribed_at->format('M j, Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-center text-muted py-4">No subscribers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscribers->hasPages())
            <div class="card-footer">{{ $subscribers->links() }}</div>
        @endif
    </div>
@endsection
