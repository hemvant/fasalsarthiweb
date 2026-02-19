@extends('layouts.app')

@section('title', $feature->meta_title ?: $feature->title . ' - ' . ($siteTitle ?? 'FasalSarthi'))
@section('meta_description', $feature->meta_description ?: Str::limit(strip_tags($feature->excerpt ?? $feature->content), 160))

@section('content')
    <section class="blog-detail-section feature-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="blog-detail-header" data-aos="fade-up">
                        @if($feature->icon)
                            <div class="feature-icon {{ $feature->icon_class }} mb-3" style="width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;"><i class="fas {{ $feature->icon }}"></i></div>
                        @endif
                        <h1 class="blog-detail-title">{{ $feature->title }}</h1>
                    </div>

                    @if($feature->featured_image)
                        <div class="blog-detail-image" style="background-image: url('{{ asset('storage/' . $feature->featured_image) }}');" data-aos="fade-up"></div>
                    @endif

                    @if($feature->excerpt)
                        <p class="lead text-muted mb-4" data-aos="fade-up">{{ $feature->excerpt }}</p>
                    @endif

                    <div class="blog-detail-content" data-aos="fade-up">
                        @if($feature->content)
                            <div class="feature-body">{!! $feature->content !!}</div>
                        @else
                            <p class="text-muted">More details coming soon.</p>
                        @endif
                    </div>

                    <div class="mt-5 pt-4 border-top" data-aos="fade-up">
                        <a href="{{ route('feature.index') }}" class="btn btn-explore"><i class="fas fa-arrow-left me-2"></i> All Features</a>
                        <a href="{{ route('home') }}#contact" class="btn btn-outline-secondary ms-2">Get In Touch</a>
                    </div>
                </div>
            </div>

            @if($relatedFeatures->isNotEmpty())
                <div class="related-posts mt-5" data-aos="fade-up">
                    <h3>Other Features</h3>
                    <div class="row g-4">
                        @foreach($relatedFeatures as $rf)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('feature.show', $rf->slug) }}" class="text-decoration-none">
                                    <div class="feature-card h-100">
                                        @if($rf->icon)
                                            <div class="feature-icon {{ $rf->icon_class }}"><i class="fas {{ $rf->icon }}"></i></div>
                                        @else
                                            <div class="feature-icon icon-green"><i class="fas fa-star"></i></div>
                                        @endif
                                        <h5>{{ $rf->title }}</h5>
                                        <p>{{ $rf->excerpt ? Str::limit($rf->excerpt, 100) : 'Learn more.' }}</p>
                                        <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
