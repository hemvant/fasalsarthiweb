@extends('admin.layout')
@section('title', 'Reports')
@section('header', 'Community Reports')

@section('content')
<div class="card">
    <table class="table table-hover mb-0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Type</th>
                <th>By</th>
                <th>Reason</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
            <tr>
                <td>{{ $report->id }}</td>
                <td>{{ class_basename($report->reportable_type) }}</td>
                <td>{{ $report->user->name ?? '-' }}</td>
                <td>{{ $report->reason ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.community.reports.resolve', $report) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-success">Resolve</button></form>
                    <form action="{{ route('admin.community.reports.dismiss', $report) }}" method="POST" class="d-inline">@csrf<button type="submit" class="btn btn-sm btn-outline-secondary">Dismiss</button></form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($reports->hasPages())<div class="card-footer">{{ $reports->links() }}</div>@endif
</div>
@endsection
