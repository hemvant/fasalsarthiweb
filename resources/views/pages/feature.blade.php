@extends('layouts.app')

@section('title', 'Features - ' . ($siteTitle ?? 'FasalSarthi'))
@section('meta_description', 'Discover how ' . ($siteTitle ?? 'FasalSarthi') . ' revolutionizes farming with AI technology, crop recommendations, weather alerts, and community support.')

@section('content')
    <!-- Hero (same style as blog/schemes inner pages) -->
    <section class="page-hero blog-hero">
        <div class="container">
            <h1 data-aos="fade-up">Our Features</h1>
            <p data-aos="fade-up" data-aos-delay="100">Discover how {{ $siteTitle ?? 'FasalSarthi' }} revolutionizes farming with cutting-edge AI, helping you increase yields, reduce costs, and make data-driven decisions.</p>
        </div>
    </section>

    <!-- Features Section (same design as index #features) -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Empowering Farmers with AI Technology</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Discover how {{ $siteTitle ?? 'FasalSarthi' }} revolutionizes farming with cutting-edge AI, helping you increase yields, reduce costs, and make data-driven decisions.</p>
            <div class="row g-4 mb-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon icon-green"><i class="fas fa-leaf"></i></div>
                        <h5>AI Crop Recommendations</h5>
                        <p>Get personalized farming advice based on your location, soil type, and weather conditions.</p>
                        <a href="{{ route('crop.index') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue"><i class="fas fa-cloud-sun"></i></div>
                        <h5>Weather Forecasts</h5>
                        <p>Access weather predictions and alerts to help you plan your farming activities.</p>
                        <a href="{{ route('home') }}#contact" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon icon-orange"><i class="fas fa-shield-alt"></i></div>
                        <h5>Disease Prevention</h5>
                        <p>Early detection and prevention tips for crop diseases through image recognition.</p>
                        <a href="{{ route('home') }}#contact" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon icon-green"><i class="fas fa-chart-line"></i></div>
                        <h5>Market Prices</h5>
                        <p>Real-time market prices and trends to help you make informed selling decisions.</p>
                        <a href="{{ route('home') }}#contact" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon icon-purple"><i class="fas fa-users"></i></div>
                        <h5>Farmer Community</h5>
                        <p>Connect with fellow farmers, share experiences, and learn from each other.</p>
                        <a href="{{ route('home') }}#contact" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="feature-card">
                        <div class="feature-icon icon-teal"><i class="fas fa-recycle"></i></div>
                        <h5>Sustainable Farming</h5>
                        <p>Eco-friendly farming practices and organic farming tips for better yields.</p>
                        <a href="{{ route('irrigation.index') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('home') }}#contact" class="btn btn-explore">Get Started Today</a>
            </div>
        </div>
    </section>

    <!-- Experience Section (same as index) -->
    <section class="experience-section" id="experience">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="section-title text-start">Experience the Future of Farming</h2>
                    <p class="text-muted mb-4">See how {{ $siteTitle ?? 'FasalSarthi' }}'s intuitive interface makes advanced farming technology accessible to every farmer, regardless of their technical background.</p>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Simple, intuitive mobile interface</span></div>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Works offline for remote areas</span></div>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Available in multiple Indian languages</span></div>
                    <a href="{{ route('home') }}#contact" class="btn btn-demo mt-4">Watch Demo Video <i class="fas fa-play-circle ms-2"></i></a>
                </div>
                <div class="col-lg-6 text-center" data-aos="fade-left" data-aos-delay="300">
                    <div class="phone-mockup mx-auto">
                        <div class="phone-frame">
                            <div class="phone-screen">
                                <div style="background: linear-gradient(to bottom, #87ceeb 0%, #a8d5ba 100%); height: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 20px; border-radius: 25px;">
                                    <h3 style="color: white; margin-bottom: 20px;">{{ $siteTitle ?? 'FasalSarthi' }}</h3>
                                    <div style="background: white; width: 100%; height: 60px; border-radius: 10px; margin-bottom: 15px; display: flex; align-items: center; padding: 0 15px;"><i class="fas fa-leaf" style="color: #4caf50; margin-right: 10px;"></i><span>Crop Recommendations</span></div>
                                    <div style="background: white; width: 100%; height: 60px; border-radius: 10px; margin-bottom: 15px; display: flex; align-items: center; padding: 0 15px;"><i class="fas fa-cloud-sun" style="color: #2196f3; margin-right: 10px;"></i><span>Weather Forecast</span></div>
                                    <div style="background: white; width: 100%; height: 60px; border-radius: 10px; margin-bottom: 15px; display: flex; align-items: center; padding: 0 15px;"><i class="fas fa-shield-alt" style="color: #ff9800; margin-right: 10px;"></i><span>Disease Detection</span></div>
                                    <div style="background: white; width: 100%; height: 60px; border-radius: 10px; display: flex; align-items: center; padding: 0 15px;"><i class="fas fa-users" style="color: #9c27b0; margin-right: 10px;"></i><span>Farmer Community</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest from Blog (dynamic) -->
    @if(isset($latestPosts) && $latestPosts->isNotEmpty())
    <section class="blog-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Latest from Blog</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Expert insights and farming tips from our team.</p>
            <div class="row g-4">
                @foreach($latestPosts as $p)
                    <div class="col-md-4" data-aos="fade-up">
                        <div class="blog-card">
                            <div class="blog-image" style="background-image: url('{{ $p->featured_image ? asset('storage/' . $p->featured_image) : 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=600' }}');"></div>
                            <div class="blog-content">
                                @if($p->category)
                                    <span class="blog-category">{{ $p->category->name }}</span>
                                @endif
                                <h3 class="blog-title"><a href="{{ route('blog.show', $p->slug) }}">{{ $p->title }}</a></h3>
                                @if($p->excerpt)
                                    <p class="blog-excerpt">{{ Str::limit($p->excerpt, 100) }}</p>
                                @endif
                                <div class="blog-meta">
                                    @if($p->published_at)
                                        <span class="date"><i class="far fa-calendar"></i> {{ $p->published_at->format('M j, Y') }}</span>
                                    @endif
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
