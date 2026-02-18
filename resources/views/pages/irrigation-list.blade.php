@extends('layouts.app')

@section('title', 'Irrigation & Water Management')
@section('meta_description', 'Smart irrigation techniques and water-saving practices for sustainable farming.')

@section('content')
    <section class="irrigation-hero">
        <div class="container">
            <h1 data-aos="fade-up">Irrigation & Water Management</h1>
            <p data-aos="fade-up" data-aos-delay="100">Smart irrigation techniques and water-saving practices for sustainable farming.</p>
        </div>
    </section>
    <section class="irrigation-section">
        <div class="container">
            @if(isset($categories) && $categories->isNotEmpty())
                <div class="row mb-4">
                    <div class="col-12">
                        <form method="GET" class="d-flex gap-2 flex-wrap align-items-center">
                            <label class="text-muted mb-0">Filter:</label>
                            <a href="{{ route('irrigation.index') }}" class="btn btn-sm {{ !request('category') ? 'btn-success' : 'btn-outline-success' }}">All</a>
                            @foreach($categories as $cat)
                                <a href="{{ route('irrigation.index', ['category' => $cat->id]) }}" class="btn btn-sm {{ request('category') == $cat->id ? 'btn-success' : 'btn-outline-success' }}">{{ $cat->name }} ({{ $cat->methods_count }})</a>
                            @endforeach
                        </form>
                    </div>
                </div>
            @endif
            <div class="row g-4">
                @forelse(isset($methods) ? $methods : [] as $m)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up">
                        <div class="blog-card irrigation-card">
                            <div class="blog-image irrigation-image" style="background-image: url('{{ $m->featured_image ? asset('storage/' . $m->featured_image) : 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600' }}');">
                                @if($m->badge_text)
                                    <span class="scheme-badge irrigation-badge">{{ $m->badge_text }}</span>
                                @endif
                            </div>
                            <div class="blog-content irrigation-content">
                                @if($m->category)
                                    <span class="blog-category irrigation-category">{{ $m->category->name }}</span>
                                @endif
                                <h3 class="blog-title irrigation-title"><a href="{{ route('irrigation.show', $m->slug) }}">{{ $m->title }}</a></h3>
                                @if($m->excerpt)
                                    <p class="blog-excerpt irrigation-excerpt">{{ Str::limit($m->excerpt, 120) }}</p>
                                @endif
                                <a href="{{ route('irrigation.show', $m->slug) }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted mb-0">No irrigation methods available yet. Check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
