@extends('layouts.app')

@section('title', 'Features - ' . ($siteTitle ?? 'FasalSarthi'))
@section('meta_description', $home['features_subtitle'] ?? 'Discover how ' . ($siteTitle ?? 'FasalSarthi') . ' revolutionizes farming with AI technology, crop recommendations, weather alerts, and community support.')

@section('content')
    <section class="page-hero blog-hero">
        <div class="container">
            <h1 data-aos="fade-up">{{ $home['features_title'] ?? 'Our Features' }}</h1>
            <p data-aos="fade-up" data-aos-delay="100">{{ $home['features_subtitle'] ?? 'Discover how ' . ($siteTitle ?? 'FasalSarthi') . ' revolutionizes farming with cutting-edge AI, helping you increase yields, reduce costs, and make data-driven decisions.' }}</p>
        </div>
    </section>

    <section class="features-section" id="features">
        <div class="container">
            @if($features->isNotEmpty())
                <div class="row g-4">
                    @foreach($features as $index => $f)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                            <a href="{{ route('feature.show', $f->slug) }}" class="text-decoration-none">
                                <div class="feature-card h-100">
                                    @if($f->icon)
                                        <div class="feature-icon {{ $f->icon_class }}"><i class="fas {{ $f->icon }}"></i></div>
                                    @else
                                        <div class="feature-icon icon-green"><i class="fas fa-star"></i></div>
                                    @endif
                                    <h5>{{ $f->title }}</h5>
                                    <p>{{ $f->excerpt ? Str::limit($f->excerpt, 120) : 'Learn more about this feature.' }}</p>
                                    <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5" data-aos="fade-up">
                    <a href="{{ route('home') }}#contact" class="btn btn-explore">Get Started Today</a>
                </div>
            @else
                <div class="text-center py-5">
                    <p class="text-muted mb-4">No features have been added yet. Check back soon.</p>
                    <a href="{{ route('home') }}#contact" class="btn btn-explore">Get In Touch</a>
                </div>
            @endif
        </div>
    </section>

    @if(isset($latestPosts) && $latestPosts->isNotEmpty())
    <section class="blog-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Latest from Blog</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Expert insights and farming tips from our team.</p>
            <div class="row g-4">
                @foreach($latestPosts as $p)
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="blog-card">
                            @if($p->featured_image)
                                <div class="blog-image" style="background-image: url('{{ asset('storage/' . $p->featured_image) }}');"></div>
                            @else
                                <div class="blog-image blog-image-placeholder"><i class="fas fa-newspaper"></i></div>
                            @endif
                            <div class="blog-content">
                                @if($p->category)<span class="blog-category">{{ $p->category->name }}</span>@endif
                                <h3 class="blog-title"><a href="{{ route('blog.show', $p->slug) }}">{{ $p->title }}</a></h3>
                                @if($p->excerpt)<p class="blog-excerpt">{{ Str::limit(strip_tags($p->excerpt), 100) }}</p>@endif
                                <div class="blog-meta">
                                    @if($p->published_at)<span class="date"><i class="far fa-calendar"></i> {{ $p->published_at->format('M j, Y') }}</span>@endif
                                </div>
                                <a href="{{ route('blog.show', $p->slug) }}" class="learn-more mt-2">Read More <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('blog.index') }}" class="btn btn-explore">View All Blog Posts</a>
            </div>
        </div>
    </section>
    @endif
@endsection
