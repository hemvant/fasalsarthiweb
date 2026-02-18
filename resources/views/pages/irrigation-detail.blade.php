@extends('layouts.app')

@section('title', $method->meta_title ?: $method->title)
@section('meta_description', $method->meta_description ?: Str::limit($method->excerpt, 160))

@section('content')
    <section class="irrigation-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="irrigation-detail-header" data-aos="fade-up">
                        @if($method->category)
                            <span class="irrigation-category blog-category">{{ $method->category->name }}</span>
                        @endif
                        <h1 class="irrigation-detail-title">{{ $method->title }}</h1>
                        <div class="irrigation-detail-meta">
                            @if($method->stat1_value)
                                <div class="water-efficiency"><i class="fas fa-tint"></i> {{ $method->stat1_value }} {{ $method->stat1_label ?: '' }}</div>
                            @endif
                            @if($method->stat2_value)
                                <div class="cost"><i class="fas fa-rupee-sign"></i> {{ $method->stat2_value }} {{ $method->stat2_label ?: '' }}</div>
                            @endif
                            @if($method->category)
                                <div class="category"><i class="fas fa-tag"></i> {{ $method->category->name }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="irrigation-detail-image" style="background-image: url('{{ $method->featured_image ? asset('storage/' . $method->featured_image) : 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=1200' }}');" data-aos="fade-up">
                        @if($method->badge_text)
                            <span class="irrigation-detail-badge">{{ $method->badge_text }}</span>
                        @endif
                    </div>

                    @if($method->stat1_value || $method->stat2_value || $method->stat3_value || $method->stat4_value)
                        <div class="irrigation-stats scheme-stats" data-aos="fade-up">
                            @if($method->stat1_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $method->stat1_value }}</div>
                                    <div class="stat-label">{{ $method->stat1_label ?: 'Stat 1' }}</div>
                                </div>
                            @endif
                            @if($method->stat2_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $method->stat2_value }}</div>
                                    <div class="stat-label">{{ $method->stat2_label ?: 'Stat 2' }}</div>
                                </div>
                            @endif
                            @if($method->stat3_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $method->stat3_value }}</div>
                                    <div class="stat-label">{{ $method->stat3_label ?: 'Stat 3' }}</div>
                                </div>
                            @endif
                            @if($method->stat4_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $method->stat4_value }}</div>
                                    <div class="stat-label">{{ $method->stat4_label ?: 'Stat 4' }}</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="irrigation-detail-content scheme-detail-content" data-aos="fade-up">
                        @if($method->about)
                            <div class="about-content">{!! $method->about !!}</div>
                        @endif
                        @if($method->content)
                            <div class="post-body">{!! $method->content !!}</div>
                        @endif
                    </div>

                    @if(isset($relatedMethods) && $relatedMethods->isNotEmpty())
                        <div class="related-posts related-schemes mt-5" data-aos="fade-up">
                            <h3>Related Irrigation Methods</h3>
                            <div class="row g-4">
                                @foreach($relatedMethods as $rm)
                                    <div class="col-md-6">
                                        <div class="blog-card scheme-card">
                                            <div class="blog-image scheme-image" style="background-image: url('{{ $rm->featured_image ? asset('storage/' . $rm->featured_image) : 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=600' }}');"></div>
                                            <div class="blog-content scheme-content">
                                                @if($rm->category)
                                                    <span class="blog-category scheme-category">{{ $rm->category->name }}</span>
                                                @endif
                                                <h3 class="blog-title scheme-title"><a href="{{ route('irrigation.show', $rm->slug) }}">{{ $rm->title }}</a></h3>
                                                @if($rm->excerpt)
                                                    <p class="blog-excerpt scheme-excerpt">{{ Str::limit($rm->excerpt, 100) }}</p>
                                                @endif
                                                <a href="{{ route('irrigation.show', $rm->slug) }}" class="btn btn-apply">Learn More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                @if(isset($categories) && $categories->isNotEmpty())
                    <div class="col-lg-4">
                        <div class="blog-sidebar schemes-sidebar">
                            <div class="sidebar-widget">
                                <h4>Irrigation Types</h4>
                                <ul class="categories-list">
                                    @foreach($categories as $c)
                                        <li>
                                            <a href="{{ route('irrigation.index', ['category' => $c->id]) }}">
                                                {{ $c->name }}
                                                <span class="count">{{ $c->methods_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
