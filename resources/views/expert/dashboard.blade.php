@extends('expert.layout')
@section('title', 'Dashboard')
@section('content')
<h3 class="mb-4">Expert Dashboard</h3>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Answers</h6>
                <h4>{{ $totalAnswers }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Rating</h6>
                <h4>{{ number_format($rating, 1) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Pending Questions</h6>
                <h4>{{ $pendingQuestions }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Status</h6>
                <h4 class="text-success">Approved</h4>
            </div>
        </div>
    </div>
</div>
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">Trending Crops (questions)</div>
    <div class="card-body">
        @forelse($trendingCrops as $cropId => $title)
            <span class="badge bg-success me-1">{{ $title }}</span>
        @empty
            <p class="text-muted mb-0">No data yet.</p>
        @endforelse
    </div>
</div>
<p class="text-muted small mt-3">Question panel, articles, and profile management can be added in the same structure.</p>
@endsection
