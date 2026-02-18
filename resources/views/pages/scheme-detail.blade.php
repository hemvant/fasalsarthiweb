@extends('layouts.app')

@section('title', $scheme->meta_title ?: $scheme->title)
@section('meta_title', $scheme->meta_title ?: $scheme->title . ' - ' . ($siteTitle ?? config('app.name')))
@section('meta_description', $scheme->meta_description ?: Str::limit($scheme->excerpt ?? $scheme->about, 160))

@section('content')
    <section class="scheme-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="scheme-detail-header" data-aos="fade-up">
                        @if($scheme->category)
                            <span class="scheme-category">{{ $scheme->category->name }}</span>
                        @endif
                        <h1 class="scheme-detail-title">{{ $scheme->title }}</h1>
                        <div class="scheme-detail-meta">
                            @if($scheme->ministry)
                                <div class="ministry"><i class="fas fa-landmark"></i> {{ $scheme->ministry }}</div>
                            @endif
                            @if($scheme->deadline)
                                <div class="deadline"><i class="far fa-calendar"></i> Deadline: {{ $scheme->deadline }}</div>
                            @endif
                            @if($scheme->category)
                                <div class="category"><i class="fas fa-tag"></i> {{ $scheme->category->name }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="scheme-detail-image" style="background-image: url('{{ $scheme->featured_image ? asset('storage/' . $scheme->featured_image) : 'https://images.unsplash.com/photo-1586773860418-d37222d8fce3?w=1200' }}');" data-aos="fade-up">
                        <span class="scheme-detail-badge">{{ $scheme->badge_text ?: 'Active' }}</span>
                    </div>

                    @if($scheme->stat1_value || $scheme->stat2_value || $scheme->stat3_value)
                        <div class="scheme-stats" data-aos="fade-up">
                            @if($scheme->stat1_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $scheme->stat1_value }}</div>
                                    <div class="stat-label">{{ $scheme->stat1_label ?: 'Stat 1' }}</div>
                                </div>
                            @endif
                            @if($scheme->stat2_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $scheme->stat2_value }}</div>
                                    <div class="stat-label">{{ $scheme->stat2_label ?: 'Stat 2' }}</div>
                                </div>
                            @endif
                            @if($scheme->stat3_value)
                                <div class="stat-item">
                                    <div class="stat-number">{{ $scheme->stat3_value }}</div>
                                    <div class="stat-label">{{ $scheme->stat3_label ?: 'Stat 3' }}</div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div class="scheme-detail-content" data-aos="fade-up">
                        @if($scheme->about)
                            <h2>About the Scheme</h2>
                            <div class="about-content">{!! $scheme->about !!}</div>
                        @endif

                        @if($scheme->benefits)
                            <div class="benefits-list">
                                <h3>Key Benefits</h3>
                                <div>{!! $scheme->benefits !!}</div>
                            </div>
                        @endif

                        @if($scheme->eligibility_criteria)
                            <div class="eligibility-criteria">
                                <h3>Eligibility Criteria</h3>
                                <div>{!! $scheme->eligibility_criteria !!}</div>
                            </div>
                        @endif

                        @if($scheme->premium_rates)
                            <h2>Premium Rates</h2>
                            <div class="premium-rates">{!! $scheme->premium_rates !!}</div>
                        @endif

                        @if($scheme->application_process)
                            <div class="application-process">
                                <h3>Application Process</h3>
                                <div>{!! $scheme->application_process !!}</div>
                            </div>
                        @endif

                        @if($scheme->documents_required)
                            <div class="documents-required">
                                <h3>Documents Required</h3>
                                <div>{!! $scheme->documents_required !!}</div>
                            </div>
                        @endif

                        @if($scheme->covered_crops)
                            <h2>Covered Crops</h2>
                            <div class="covered-crops">{!! $scheme->covered_crops !!}</div>
                        @endif

                        @if($scheme->claim_process)
                            <h2>Claim Process</h2>
                            <div class="claim-process">{!! $scheme->claim_process !!}</div>
                        @endif

                        @if($scheme->apply_cta_title || $scheme->apply_cta_button_url)
                            <div class="apply-cta">
                                @if($scheme->apply_cta_title)
                                    <h3>{{ $scheme->apply_cta_title }}</h3>
                                @endif
                                @if($scheme->apply_cta_text)
                                    <p>{{ $scheme->apply_cta_text }}</p>
                                @endif
                                @if($scheme->apply_cta_button_url)
                                    <a href="{{ $scheme->apply_cta_button_url }}" class="btn btn-secondary btn-lg mt-3" target="_blank" rel="noopener">
                                        <i class="fas fa-file-alt me-2"></i>{{ $scheme->apply_cta_button_text ?: 'Apply Online Now' }}
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    @if($relatedSchemes->isNotEmpty())
                        <div class="related-schemes" data-aos="fade-up">
                            <h3>Related Schemes</h3>
                            <div class="row g-4">
                                @foreach($relatedSchemes as $rs)
                                    <div class="col-md-6">
                                        <div class="scheme-card">
                                            <div class="scheme-image" style="background-image: url('{{ $rs->featured_image ? asset('storage/' . $rs->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');">
                                                @if($rs->badge_text)
                                                    <span class="scheme-badge">{{ $rs->badge_text }}</span>
                                                @else
                                                    <span class="scheme-badge">Active</span>
                                                @endif
                                            </div>
                                            <div class="scheme-content">
                                                @if($rs->category)
                                                    <span class="scheme-category">{{ $rs->category->name }}</span>
                                                @endif
                                                <h3 class="scheme-title"><a href="{{ route('scheme.show', $rs->slug) }}">{{ $rs->title }}</a></h3>
                                                @if($rs->excerpt)
                                                    <p class="scheme-excerpt">{{ Str::limit($rs->excerpt, 100) }}</p>
                                                @endif
                                                <a href="{{ route('scheme.show', $rs->slug) }}" class="btn btn-apply">View Details</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="schemes-sidebar">
                        @if($scheme->apply_cta_button_url)
                            <div class="sidebar-widget">
                                <h4>Quick Apply</h4>
                                <p>Apply for this scheme directly through the official portal.</p>
                                <a href="{{ $scheme->apply_cta_button_url }}" class="btn btn-submit w-100 mb-3" target="_blank" rel="noopener"><i class="fas fa-file-alt me-2"></i>Online Application</a>
                            </div>
                        @endif

                        @if($scheme->helpline_phone || $scheme->helpline_email)
                            <div class="sidebar-widget">
                                <h4>Scheme Helpline</h4>
                                @if($scheme->helpline_phone)
                                    <div class="contact-info-item">
                                        <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                                        <div>
                                            <h5>Toll-Free / Helpline</h5>
                                            <p class="mb-0">{{ $scheme->helpline_phone }}</p>
                                        </div>
                                    </div>
                                @endif
                                @if($scheme->helpline_email)
                                    <div class="contact-info-item">
                                        <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                                        <div>
                                            <h5>Email Support</h5>
                                            <p class="mb-0"><a href="mailto:{{ $scheme->helpline_email }}">{{ $scheme->helpline_email }}</a></p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if(is_array($scheme->resources) && count($scheme->resources) > 0)
                            <div class="sidebar-widget">
                                <h4>Resources</h4>
                                <ul class="categories-list">
                                    @foreach($scheme->resources as $res)
                                        <li><a href="{{ $res['url'] ?? '#' }}" target="_blank" rel="noopener"><i class="fas fa-file-alt me-2"></i>{{ $res['title'] ?? 'Link' }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($scheme->important_dates)
                            <div class="sidebar-widget">
                                <h4>Important Dates</h4>
                                <div>{!! $scheme->important_dates !!}</div>
                            </div>
                        @endif

                        @if($categories->isNotEmpty())
                            <div class="sidebar-widget">
                                <h4>Scheme Categories</h4>
                                <ul class="categories-list">
                                    @foreach($categories as $c)
                                        <li>
                                            <a href="{{ route('scheme.index', ['category' => $c->id]) }}">
                                                {{ $c->name }}
                                                <span class="count">{{ $c->schemes_count }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
