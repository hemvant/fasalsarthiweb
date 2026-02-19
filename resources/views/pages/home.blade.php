@extends('layouts.app')

@section('title', $siteTitle ?? 'FasalSarthi')
@section('meta_description', $metaDescription ?? ($home['hero_subtitle'] ?? 'AI-powered farming assistant for crop recommendations, weather alerts, and farmer community.'))

@section('content')
    <!-- Hero Section -->
    <section class="hero-section" id="home">
        <div class="hero-video-container">
            <video class="hero-video" autoplay muted loop playsinline>
                <source src="https://assets.mixkit.co/videos/preview/mixkit-green-field-with-trees-and-a-mountain-in-the-background-43330-large.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 hero-content" data-aos="fade-right">
                    <h1>{{ $home['hero_title_prefix'] ?? 'Where' }} <span class="highlight">{{ $home['hero_title_highlight'] ?? 'AI Meets Agriculture' }}</span></h1>
                    <p>{{ $home['hero_subtitle'] ?? 'Get personalized crop recommendations, weather alerts, disease prevention tips, and connect with a community of farmers - all powered by advanced AI technology.' }}</p>
                    <a href="{{ route('home') }}#contact" class="btn btn-get-started">{{ $home['hero_cta_text'] ?? 'Get Started Today' }}</a>
                    <div class="stats">
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                            <div class="number">{{ $home['hero_stat1_number'] ?? '50K+' }}</div>
                            <div class="label">{{ $home['hero_stat1_label'] ?? 'Active farmers' }}</div>
                        </div>
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                            <div class="number">{{ $home['hero_stat2_number'] ?? '4.8' }}</div>
                            <div class="label">{{ $home['hero_stat2_label'] ?? 'App Rating' }}</div>
                        </div>
                        <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                            <div class="number">{{ $home['hero_stat3_number'] ?? '30%' }}</div>
                            <div class="label">{{ $home['hero_stat3_label'] ?? 'Better Yields' }}</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 text-center" data-aos="fade-left" data-aos-delay="300">
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

    <!-- Featured Crops (dynamic) -->
    @if($featuredCrops->isNotEmpty())
    <section class="featured-crops-section py-5" id="crops">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Explore Crops</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Discover crop guides, growing tips, and profit analysis from our database.</p>
            <div class="row g-4">
                @foreach($featuredCrops as $index => $crop)
                <div class="col-6 col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 50 }}">
                    <a href="{{ route('crop.show', $crop->slug) }}" class="crop-card-link text-decoration-none">
                        <div class="crop-card home-crop-card h-100">
                            @if($crop->featured_image)
                            <div class="crop-image home-crop-image" style="background-image: url('{{ asset('storage/' . $crop->featured_image) }}');"></div>
                            @else
                            <div class="crop-image home-crop-image crop-image-placeholder"><i class="fas fa-leaf"></i></div>
                            @endif
                            <div class="crop-content home-crop-content">
                                @if($crop->category)<span class="blog-category">{{ $crop->category->title }}</span>@endif
                                <h5 class="crop-title">{{ $crop->title }}</h5>
                                @if($crop->excerpt)<p class="crop-excerpt small mb-0">{{ Str::limit(strip_tags($crop->excerpt), 80) }}</p>@endif
                                <span class="learn-more mt-2 d-inline-block">View guide <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('crop.index') }}" class="btn btn-explore">View All Crops</a>
            </div>
        </div>
    </section>
    @endif

    <!-- Features Section (dynamic from admin) -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">{{ $home['features_title'] ?? 'Empowering Farmers with AI Technology' }}</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $home['features_subtitle'] ?? 'Discover how ' . ($siteTitle ?? 'FasalSarthi') . ' revolutionizes farming with cutting-edge AI, helping you increase yields, reduce costs, and make data-driven decisions.' }}</p>
            @if(isset($features) && $features->isNotEmpty())
                <div class="row g-4">
                    @foreach($features as $index => $f)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ 200 + $index * 50 }}">
                            <a href="{{ route('feature.show', $f->slug) }}" class="feature-card-link text-decoration-none">
                                <div class="feature-card h-100">
                                    @if($f->icon)
                                        <div class="feature-icon {{ $f->icon_class }}"><i class="fas {{ $f->icon }}"></i></div>
                                    @else
                                        <div class="feature-icon icon-green"><i class="fas fa-star"></i></div>
                                    @endif
                                    <h5>{{ $f->title }}</h5>
                                    <p>{{ $f->excerpt ? Str::limit($f->excerpt, 100) : 'Learn more about this feature.' }}</p>
                                    <span class="learn-more">Learn More <i class="fas fa-arrow-right"></i></span>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
                    <a href="{{ route('feature.index') }}" class="btn btn-explore">Explore All Features</a>
                </div>
            @else
                <div class="text-center py-4" data-aos="fade-up">
                    <a href="{{ route('feature.index') }}" class="btn btn-explore">Explore Features</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Latest from Blog (dynamic) -->
    @if($latestPosts->isNotEmpty())
    <section class="latest-blog-section py-5 bg-white" id="blog-preview">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Latest from Blog</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Tips, schemes, and farming insights from our experts.</p>
            <div class="row g-4">
                @foreach($latestPosts as $index => $post)
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ 100 + $index * 100 }}">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                        <div class="blog-card h-100">
                            @if($post->featured_image)
                            <div class="blog-image" style="background-image: url('{{ asset('storage/' . $post->featured_image) }}');"></div>
                            @else
                            <div class="blog-image blog-image-placeholder"><i class="fas fa-newspaper"></i></div>
                            @endif
                            <div class="blog-content">
                                @if($post->category)<span class="blog-category">{{ $post->category->title }}</span>@endif
                                <h5 class="blog-title">{{ $post->title }}</h5>
                                @if($post->excerpt)<p class="blog-excerpt">{{ Str::limit(strip_tags($post->excerpt), 100) }}</p>@endif
                                <div class="blog-meta">
                                    @if($post->published_at)<span class="date"><i class="far fa-calendar-alt"></i> {{ $post->published_at->format('M j, Y') }}</span>@endif
                                </div>
                                <span class="learn-more mt-2 d-inline-block">Read more <i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-4" data-aos="fade-up">
                <a href="{{ route('blog.index') }}" class="btn btn-explore">View All Articles</a>
            </div>
        </div>
    </section>
    @endif

    <!-- Experience Section -->
    <section class="experience-section" id="experience">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="section-title text-start">{{ $home['experience_title'] ?? 'Experience the Future of Farming' }}</h2>
                    <p class="text-muted mb-4">{{ $home['experience_subtitle'] ?? "See how " . ($siteTitle ?? "FasalSarthi") . "'s intuitive interface makes advanced farming technology accessible to every farmer, regardless of their technical background." }}</p>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Simple, intuitive mobile interface</span></div>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Works offline for remote areas</span></div>
                    <div class="checkmark-item"><div class="checkmark"><i class="fas fa-check"></i></div><span>Available in multiple Indian languages</span></div>
                    <a href="{{ route('home') }}#contact" class="btn btn-demo mt-4">{{ $home['experience_btn_text'] ?? 'Watch Demo Video' }} <i class="fas fa-play-circle ms-2"></i></a>
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

    <!-- Testimonials Section -->
    <section class="testimonials-section" id="testimonials">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">{{ $home['testimonials_title'] ?? 'What Farmers Are Saying' }}</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $home['testimonials_subtitle'] ?? 'Join thousands of farmers who have transformed their farming practices with ' . ($siteTitle ?? 'FasalSarthi') . '. Here are some of their success stories.' }}</p>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">{{ $home['testimonial1_quote'] ?? "This disease detection tool increased my wheat yield by 25% this season. The AI recommendations were spot-on, and the weather alerts saved my entire crop from pest damage." }}</p>
                        <div class="testimonial-author"><div class="author-avatar">{{ isset($home['testimonial1_name']) ? strtoupper(substr(str_replace(' ', '', $home['testimonial1_name']), 0, 2)) : 'RK' }}</div><div class="author-info"><h6>{{ $home['testimonial1_name'] ?? 'Rajesh Kumar' }}</h6><p>{{ $home['testimonial1_role'] ?? 'Wheat Farmer' }}</p></div></div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">{{ $home['testimonial2_quote'] ?? "The disease detection feature is amazing! It identified blight early and I was able to take preventive measures. The app is user-friendly and in my language." }}</p>
                        <div class="testimonial-author"><div class="author-avatar">{{ isset($home['testimonial2_name']) ? strtoupper(substr(str_replace(' ', '', $home['testimonial2_name']), 0, 2)) : 'PP' }}</div><div class="author-info"><h6>{{ $home['testimonial2_name'] ?? 'Priya Patel' }}</h6><p>{{ $home['testimonial2_role'] ?? 'Cotton Farmer' }}</p></div></div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="testimonial-card">
                        <div class="stars"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-text">{{ $home['testimonial3_quote'] ?? "FasalSarthi's community support feature has been invaluable. I was able to get answers from experienced farmers and learn new techniques that improved my yield." }}</p>
                        <div class="testimonial-author"><div class="author-avatar">{{ isset($home['testimonial3_name']) ? strtoupper(substr(str_replace(' ', '', $home['testimonial3_name']), 0, 2)) : 'SY' }}</div><div class="author-info"><h6>{{ $home['testimonial3_name'] ?? 'Suresh Yadav' }}</h6><p>{{ $home['testimonial3_role'] ?? 'Vegetable Farmer' }}</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section" id="contact">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">Get In Touch With Us</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">Have questions about FasalSarthi? Our agricultural experts are here to help you with any queries about farming, technology, or our services.</p>
            <div class="row g-5">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="contact-card">
                        <h3 class="mb-4" style="color: var(--primary-green);">Send Us a Message</h3>
                        <div id="contactFormMessage" class="d-none"></div>
                        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
                        @if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>@endif
                        <form id="contactForm" action="{{ route('contact.submit') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6"><div class="mb-3"><label for="firstName" class="form-label">First Name</label><input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter your first name" value="{{ old('first_name') }}" required></div></div>
                                <div class="col-md-6"><div class="mb-3"><label for="lastName" class="form-label">Last Name</label><input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter your last name" value="{{ old('last_name') }}" required></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><div class="mb-3"><label for="contactEmail" class="form-label">Email Address</label><input type="email" class="form-control" id="contactEmail" name="email" placeholder="Enter your email" value="{{ old('email') }}" required></div></div>
                                <div class="col-md-6"><div class="mb-3"><label for="phone" class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="{{ old('phone') }}"></div></div>
                            </div>
                            <div class="mb-3"><label for="message" class="form-label">Your Message</label><textarea class="form-control" id="message" name="message" rows="5" placeholder="Tell us about your farming challenges or how we can help you..." required>{{ old('message') }}</textarea></div>
                            <button type="submit" class="btn btn-submit" id="contactFormSubmitBtn">Send Message</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="contact-info">
                        <h3 class="mb-4">Contact Information</h3>
                        @if(!empty($siteAddress))
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div><h5>Our Office</h5><p>{!! nl2br(e($siteAddress)) !!}</p></div>
                        </div>
                        @endif
                        @if(!empty($contactPhone))
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-phone"></i></div>
                            <div><h5>Phone Number</h5><p>{{ $contactPhone }}@if(!empty($contactPhoneAlt))<br>{{ $contactPhoneAlt }}@endif</p></div>
                        </div>
                        @endif
                        @if(!empty($contactEmail))
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-envelope"></i></div>
                            <div><h5>Email Address</h5><p>{{ $contactEmail }}</p></div>
                        </div>
                        @endif
                        @if(!empty($workingHours))
                        <div class="contact-info-item">
                            <div class="contact-info-icon"><i class="fas fa-clock"></i></div>
                            <div><h5>Working Hours</h5><p>{!! nl2br(e($workingHours)) !!}</p></div>
                        </div>
                        @endif
                        @if(empty($siteAddress) && empty($contactPhone) && empty($contactEmail) && empty($workingHours))
                        <p class="mb-0 opacity-75">Set contact details in Admin → Site Settings.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">{{ $home['cta_title'] ?? 'Ready to Transform Your Farming?' }}</h2>
            <p class="text-center text-muted" data-aos="fade-up" data-aos-delay="100">{{ $home['cta_subtitle'] ?? 'Join the growing community of successful farmers using AI-powered insights.' }}</p>
            <div class="cta-stats" data-aos="fade-up" data-aos-delay="200">
                <div class="cta-stat"><div class="number">{{ $home['cta_stat1_number'] ?? '50,000+' }}</div><div class="label">{{ $home['cta_stat1_label'] ?? 'Happy Farmers' }}</div></div>
                <div class="cta-stat"><div class="number">{{ $home['cta_stat2_number'] ?? '4.8★' }}</div><div class="label">{{ $home['cta_stat2_label'] ?? 'App Store Rating' }}</div></div>
                <div class="cta-stat"><div class="number">{{ $home['cta_stat3_number'] ?? '30%' }}</div><div class="label">{{ $home['cta_stat3_label'] ?? 'Average Yield Increase' }}</div></div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-5 bg-white border-top" id="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up">
                    <h2 class="section-title">Subscribe to Our Newsletter</h2>
                    <p class="section-subtitle mb-4">Get farming tips, weather alerts, and scheme updates in your inbox.</p>
                    <div id="newsletterMessage" class="d-none mb-3"></div>
                    <form id="newsletterForm" class="d-flex flex-column flex-sm-row gap-2 justify-content-center align-items-center">
                        @csrf
                        <input type="email" name="email" id="newsletterEmail" class="form-control" placeholder="Your email address" style="max-width: 320px;" required>
                        <button type="submit" class="btn btn-success px-4" id="newsletterBtn">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Community + Try AI -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6" data-aos="fade-up">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon icon-green mx-auto mb-3" style="width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;"><i class="fas fa-users"></i></div>
                            <h3 class="h5">Join Farmer Community</h3>
                            <p class="text-muted small mb-3">Connect with farmers, share experiences, and get expert answers.</p>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#joinCommunityModal">Join Now</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon icon-blue mx-auto mb-3" style="width:64px;height:64px;border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:1.75rem;"><i class="fas fa-robot"></i></div>
                            <h3 class="h5">Try AI Tools Free</h3>
                            <p class="text-muted small mb-3">3 free AI chats and 3 free disease identifications. Download app for more.</p>
                            <a href="{{ route('try-ai') }}" class="btn btn-success">Try AI Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Join Community Modal -->
    <div class="modal fade" id="joinCommunityModal" tabindex="-1" aria-labelledby="joinCommunityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="joinCommunityModalLabel"><i class="fas fa-users me-2"></i>Join Farmer Community</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <p class="lead mb-3">To join our farmer community, please download our mobile app.</p>
                    <p class="text-muted small mb-4">Get unlimited AI help, disease identification, and connect with experts and farmers on the app.</p>
                    <a href="{{ route('home') }}#contact" class="btn btn-success btn-lg" data-bs-dismiss="modal">Download App</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Final CTA -->
    <section class="final-cta">
        <div class="container">
            <h2 data-aos="fade-up">{{ $home['final_cta_title'] ?? 'Ready to Transform Your Farming?' }}</h2>
            <p data-aos="fade-up" data-aos-delay="100">{{ $home['final_cta_subtitle'] ?? 'Join thousands of farmers who are already using AI to improve their yields, reduce costs, and build sustainable farming practices.' }}</p>
            <div class="cta-buttons" data-aos="fade-up" data-aos-delay="200">
                <a href="{{ route('home') }}#contact" class="btn btn-secondary"><i class="fas fa-download me-2"></i>{{ $home['final_cta_btn_primary'] ?? 'Download from Google Play' }}</a>
                <a href="{{ route('home') }}#contact" class="btn btn-outline"><i class="fas fa-phone me-2"></i>{{ $home['final_cta_btn_secondary'] ?? 'Schedule a Demo' }}</a>
            </div>
        </div>
    </section>
@push('scripts')
<script>
(function() {
    var form = document.getElementById('contactForm');
    var messageEl = document.getElementById('contactFormMessage');
    var submitBtn = document.getElementById('contactFormSubmitBtn');
    if (!form || !messageEl) return;

    function showMessage(html, isError) {
        messageEl.innerHTML = html;
        messageEl.className = 'alert alert-' + (isError ? 'danger' : 'success') + ' mb-3';
        messageEl.classList.remove('d-none');
    }

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        var fd = new FormData(form);
        var token = document.querySelector('input[name="_token"]');
        if (token) fd.append('_token', token.value);

        submitBtn.disabled = true;
        messageEl.classList.add('d-none');

        fetch(form.action, {
            method: 'POST',
            body: fd,
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(function(r) { return r.json().then(function(d) { return { ok: r.ok, status: r.status, data: d }; }); })
        .then(function(result) {
            if (result.ok && result.data && result.data.success) {
                showMessage(result.data.message || 'Thank you! We have received your message and will get back to you soon.', false);
                form.reset();
            } else if (result.data && result.data.errors) {
                var list = '<ul class="mb-0">';
                for (var k in result.data.errors) { (result.data.errors[k] || []).forEach(function(m) { list += '<li>' + m + '</li>'; }); }
                list += '</ul>';
                showMessage(list, true);
            } else {
                showMessage(result.data && result.data.message ? result.data.message : 'Something went wrong. Please try again.', true);
            }
        })
        .catch(function() {
            showMessage('Could not send message. Please check your connection and try again.', true);
        })
        .finally(function() {
            submitBtn.disabled = false;
        });
    });
})();

        // Newsletter
        var newsletterForm = document.getElementById('newsletterForm');
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = document.getElementById('newsletterBtn');
                var msgEl = document.getElementById('newsletterMessage');
                var email = document.getElementById('newsletterEmail').value.trim();
                if (!email) return;
                btn.disabled = true;
                msgEl.classList.add('d-none');
                var fd = new FormData();
                fd.append('email', email);
                var t = document.querySelector('meta[name="csrf-token"]'); if (t) fd.append('_token', t.getAttribute('content'));
                fetch('{{ route("newsletter.subscribe") }}', {
                    method: 'POST',
                    body: fd,
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(function(r) { return r.json(); })
                .then(function(d) {
                    msgEl.innerHTML = d.message || 'Subscribed!';
                    msgEl.className = 'alert alert-' + (d.success ? 'success' : 'danger') + ' mb-3';
                    msgEl.classList.remove('d-none');
                    if (d.success) newsletterForm.reset();
                })
                .catch(function() {
                    msgEl.innerHTML = 'Could not subscribe. Try again.';
                    msgEl.className = 'alert alert-danger mb-3';
                    msgEl.classList.remove('d-none');
                })
                .finally(function() { btn.disabled = false; });
            });
        }
    })();
</script>
@endpush
@endsection
