@extends('layouts.app')

@section('title', 'Government Schemes')
@section('meta_title', 'Government Schemes for Farmers - ' . ($siteTitle ?? config('app.name')))
@section('meta_description', 'Explore government schemes and subsidies designed to support farmers and boost agricultural productivity.')

@section('content')
    <section class="schemes-hero">
        <div class="container">
            <h1 data-aos="fade-up">Government Schemes for Farmers</h1>
            <p data-aos="fade-up" data-aos-delay="100">Explore government schemes and subsidies designed to support farmers and boost agricultural productivity.</p>
        </div>
    </section>
    <section class="schemes-section">
        <div class="container">
            @if($categories->isNotEmpty())
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                            <label class="text-muted mb-0">Filter:</label>
                            <a href="{{ route('scheme.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-success' }}">All</a>
                            @foreach($categories as $cat)
                                <a href="{{ route('scheme.index', ['category' => $cat->id]) }}" class="btn btn-sm {{ request('category') == $cat->id ? 'btn-success' : 'btn-outline-success' }}">{{ $cat->name }} ({{ $cat->schemes_count }})</a>
                            @endforeach
                        </form>
                    </div>
                </div>
            @endif
            <div class="row g-4">
                @forelse($schemes as $s)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="scheme-card">
                            <div class="scheme-image" style="background-image: url('{{ $s->featured_image ? asset('storage/' . $s->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');">
                                @if($s->badge_text)
                                    <span class="scheme-badge">{{ $s->badge_text }}</span>
                                @else
                                    <span class="scheme-badge">Active</span>
                                @endif
                            </div>
                            <div class="scheme-content">
                                @if($s->category)
                                    <span class="scheme-category">{{ $s->category->name }}</span>
                                @endif
                                <h3 class="scheme-title"><a href="{{ route('scheme.show', $s->slug) }}">{{ $s->title }}</a></h3>
                                @if($s->excerpt)
                                    <p class="scheme-excerpt">{{ Str::limit($s->excerpt, 120) }}</p>
                                @endif
                                @if(is_array($s->benefit_tags) && count($s->benefit_tags) > 0)
                                    <div class="scheme-benefits">
                                        @foreach(array_slice($s->benefit_tags, 0, 4) as $tag)
                                            <span class="benefit-tag">{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif
                                <a href="{{ route('scheme.show', $s->slug) }}" class="btn btn-apply">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No schemes available at the moment. Check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
