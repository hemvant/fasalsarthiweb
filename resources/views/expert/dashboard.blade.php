@extends('expert.layout')
@section('title', 'Dashboard')
@section('content')
<h3 class="page-title">Expert Dashboard</h3>
<p class="page-subtitle">Overview of your activity and status.</p>

<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small mb-2">Total Answers</h6>
                <h4 class="mb-0 text-success">{{ $totalAnswers }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small mb-2">Rating</h6>
                <h4 class="mb-0">{{ number_format($rating, 1) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small mb-2">Pending Questions</h6>
                <h4 class="mb-0">{{ $pendingQuestions }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted text-uppercase small mb-2">Status</h6>
                <h4 class="mb-0 text-success"><i class="fas fa-check-circle me-1"></i> Approved</h4>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header"><i class="fas fa-chart-line me-2"></i>Trending Crops (questions)</div>
    <div class="card-body">
        @forelse($trendingCrops as $cropId => $title)
            <span class="badge bg-success me-1 mb-1">{{ $title }}</span>
        @empty
            <p class="text-muted mb-0">No data yet.</p>
        @endforelse
    </div>
</div>
@endsection
