@extends('layouts.app')

@section('title', $crop->meta_title ?? $crop->title)
@section('meta_description', $crop->meta_description)

@section('content')
    <section class="crop-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="crop-detail-header" data-aos="fade-up">
                        @if($crop->category)
                            <span class="crop-category">{{ $crop->category->name }}</span>
                        @endif
                        <h1 class="crop-detail-title">{{ $crop->title }}</h1>
                        <div class="crop-detail-meta">
                            @if($crop->season)<div class="season"><i class="fas fa-sun"></i> {{ $crop->season }}</div>@endif
                            @if($crop->duration)<div class="duration"><i class="fas fa-clock"></i> {{ $crop->duration }}</div>@endif
                        </div>
                    </div>

                    <div class="crop-detail-image" style="background-image: url('{{ $crop->featured_image ? asset('storage/' . $crop->featured_image) : 'https://images.unsplash.com/photo-1592409065737-253c695e459c?w=1200' }}');" data-aos="fade-up">
                        @if($crop->badge_text)<span class="crop-detail-badge">{{ $crop->badge_text }}</span>@endif
                    </div>

                    @if($crop->stat_yield || $crop->stat_profit || $crop->stat_temperature || $crop->stat_rainfall)
                        <div class="crop-stats" data-aos="fade-up">
                            @if($crop->stat_yield)<div class="stat-item"><div class="stat-number">{{ $crop->stat_yield }}</div><div class="stat-label">{{ $crop->stat_yield_label ?? 'Yield' }}</div></div>@endif
                            @if($crop->stat_profit)<div class="stat-item"><div class="stat-number">{{ $crop->stat_profit }}</div><div class="stat-label">{{ $crop->stat_profit_label ?? 'Profit/Acre' }}</div></div>@endif
                            @if($crop->stat_temperature)<div class="stat-item"><div class="stat-number">{{ $crop->stat_temperature }}</div><div class="stat-label">{{ $crop->stat_temperature_label ?? 'Temperature' }}</div></div>@endif
                            @if($crop->stat_rainfall)<div class="stat-item"><div class="stat-number">{{ $crop->stat_rainfall }}</div><div class="stat-label">{{ $crop->stat_rainfall_label ?? 'Rainfall' }}</div></div>@endif
                        </div>
                    @endif

                    <div class="crop-detail-content" data-aos="fade-up">
                        @if($crop->about)
                            <h2>About {{ $crop->title }}</h2>
                            {!! $crop->about !!}
                        @endif

                        @if($crop->suitable_regions)
                            <div class="suitable-regions">
                                <h3>Major Growing Regions</h3>
                                {!! $crop->suitable_regions !!}
                            </div>
                        @endif

                        @if($crop->soil_requirements)
                            <div class="soil-requirements">
                                <h3>Soil & Climate Requirements</h3>
                                {!! $crop->soil_requirements !!}
                            </div>
                        @endif

                        @if($crop->varieties && count($crop->varieties) > 0)
                            <h2>Popular Varieties</h2>
                            <div class="varieties-grid">
                                @foreach($crop->varieties as $v)
                                    <div class="variety-card">
                                        <h5>{{ $v['name'] ?? '' }}</h5>
                                        @if(!empty($v['duration']))<p><strong>Duration:</strong> {{ $v['duration'] }}</p>@endif
                                        @if(!empty($v['yield']))<p><strong>Yield:</strong> {{ $v['yield'] }}</p>@endif
                                        @if(!empty($v['features']))<p><strong>Features:</strong> {{ $v['features'] }}</p>@endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($crop->growing_guide)
                            <div class="growing-guide">
                                <h3>Complete Growing Guide</h3>
                                {!! $crop->growing_guide !!}
                            </div>
                        @endif

                        @if($crop->growth_stages && count($crop->growth_stages) > 0)
                            <h2>Growth Stages</h2>
                            <div class="growth-stages">
                                @foreach($crop->growth_stages as $stage)
                                    <div class="stage-card">
                                        <div class="stage-icon"><i class="{{ $stage['icon'] ?? 'fas fa-seedling' }}"></i></div>
                                        <h5>{{ $stage['title'] ?? '' }}</h5>
                                        @if(!empty($stage['duration']))<p><strong>Duration:</strong> {{ $stage['duration'] }}</p>@endif
                                        @if(!empty($stage['description']))<p>{{ $stage['description'] }}</p>@endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        @if($crop->pest_management)
                            <div class="pest-management">
                                <h3>Pest & Disease Management</h3>
                                {!! $crop->pest_management !!}
                            </div>
                        @endif

                        @if($crop->harvesting_guide)
                            <div class="harvesting-guide">
                                <h3>Harvesting & Post-Harvest</h3>
                                {!! $crop->harvesting_guide !!}
                            </div>
                        @endif

                        @if($crop->profit_analysis)
                            <div class="profit-analysis">
                                <h3>Cost & Profit Analysis (Per Acre)</h3>
                                {!! $crop->profit_analysis !!}
                            </div>
                        @endif

                        @if($crop->government_support)
                            <h2>Government Support & Schemes</h2>
                            {!! $crop->government_support !!}
                        @endif
                    </div>

                    @if($relatedCrops->isNotEmpty())
                        <div class="related-schemes mt-5" data-aos="fade-up">
                            <h3>Related Crops</h3>
                            <div class="row">
                                @foreach($relatedCrops as $rel)
                                    <div class="col-md-6 mb-3">
                                        <div class="crop-card">
                                            <div class="crop-image" style="background-image: url('{{ $rel->featured_image ? asset('storage/' . $rel->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');">
                                                @if($rel->badge_text)<span class="crop-badge">{{ $rel->badge_text }}</span>@endif
                                            </div>
                                            <div class="crop-content">
                                                @if($rel->category)<span class="crop-category">{{ $rel->category->name }}</span>@endif
                                                <h3 class="crop-title"><a href="{{ route('crop.show', $rel->slug) }}">{{ $rel->title }}</a></h3>
                                                <p class="crop-excerpt">{{ Str::limit($rel->excerpt, 80) }}</p>
                                                <a href="{{ route('crop.show', $rel->slug) }}" class="btn btn-learn-more">View Farming Guide</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="crops-sidebar">
                        <div class="sidebar-widget">
                            <h4>Quick Links</h4>
                            <ul class="categories-list">
                                <li><a href="{{ route('crop.index') }}"><i class="fas fa-list me-2"></i>All Crops</a></li>
                                @foreach($categories ?? [] as $cat)
                                    @if($cat->crops_count > 0)
                                        <li><a href="{{ route('crop.index') }}?category={{ $cat->id }}">{{ $cat->name }} <span class="count">{{ $cat->crops_count }}</span></a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
