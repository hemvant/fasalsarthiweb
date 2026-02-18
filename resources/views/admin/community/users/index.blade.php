@extends('admin.layout')
@section('title', 'Community Users')
@section('header', 'Community Users')

@section('content')
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Expert</th>
                    <th>Banned</th>
                    <th>Suspended</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->expertProfile && $u->expertProfile->status === 'approved' ? 'Yes' : 'No' }}</td>
                    <td>{{ $u->is_banned ? 'Yes' : 'No' }}</td>
                    <td>{{ $u->suspended_until ? $u->suspended_until->format('Y-m-d') : '-' }}</td>
                    <td>
                        @if($u->is_banned)
                        <form action="{{ route('admin.community.users.unban', $u) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-success">Unban</button></form>
                        @else
                        <form action="{{ route('admin.community.users.ban', $u) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-danger">Ban</button></form>
                        @endif
                        @if($u->suspended_until)
                        <form action="{{ route('admin.community.users.unsuspend', $u) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-secondary">Unsuspend</button></form>
                        @else
                        <form action="{{ route('admin.community.users.suspend', $u) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="datetime-local" name="suspended_until" class="form-control form-control-sm d-inline-block" style="width:auto">
                            <button type="submit" class="btn btn-sm btn-outline-warning">Suspend</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">No users.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())<div class="card-footer">{{ $users->links() }}</div>@endif
</div>
@endsection
