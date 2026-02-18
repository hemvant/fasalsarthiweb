@extends('layouts.app')

@section('title', $siteTitle ?? 'FasalSarthi')

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

    <!-- Features Section -->
    <section class="features-section" id="features">
        <div class="container">
            <h2 class="section-title" data-aos="fade-up">{{ $home['features_title'] ?? 'Empowering Farmers with AI Technology' }}</h2>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">{{ $home['features_subtitle'] ?? 'Discover how ' . ($siteTitle ?? 'FasalSarthi') . ' revolutionizes farming with cutting-edge AI, helping you increase yields, reduce costs, and make data-driven decisions.' }}</p>
            <div class="row g-4 mb-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="feature-icon icon-green"><i class="fas fa-leaf"></i></div>
                        <h5>AI Crop Recommendations</h5>
                        <p>Get personalized farming advice based on your location, soil type, and weather conditions.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="feature-icon icon-blue"><i class="fas fa-cloud-sun"></i></div>
                        <h5>Weather Forecasts</h5>
                        <p>Access weather predictions and alerts to help you plan your farming activities.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="feature-card">
                        <div class="feature-icon icon-orange"><i class="fas fa-shield-alt"></i></div>
                        <h5>Disease Prevention</h5>
                        <p>Early detection and prevention tips for crop diseases through image recognition.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="feature-card">
                        <div class="feature-icon icon-green"><i class="fas fa-chart-line"></i></div>
                        <h5>Market Prices</h5>
                        <p>Real-time market prices and trends to help you make informed selling decisions.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="feature-card">
                        <div class="feature-icon icon-purple"><i class="fas fa-users"></i></div>
                        <h5>Farmer Community</h5>
                        <p>Connect with fellow farmers, share experiences, and learn from each other.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="feature-card">
                        <div class="feature-icon icon-teal"><i class="fas fa-recycle"></i></div>
                        <h5>Sustainable Farming</h5>
                        <p>Eco-friendly farming practices and organic farming tips for better yields.</p>
                        <a href="{{ route('feature') }}" class="learn-more">Learn More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5" data-aos="fade-up" data-aos-delay="800">
                <a href="{{ route('feature') }}" class="btn btn-explore">Explore All Features</a>
            </div>
        </div>
    </section>

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
                        <form id="contactForm" action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-6"><div class="mb-3"><label for="firstName" class="form-label">First Name</label><input type="text" class="form-control" id="firstName" name="first_name" placeholder="Enter your first name" required></div></div>
                                <div class="col-md-6"><div class="mb-3"><label for="lastName" class="form-label">Last Name</label><input type="text" class="form-control" id="lastName" name="last_name" placeholder="Enter your last name" required></div></div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"><div class="mb-3"><label for="contactEmail" class="form-label">Email Address</label><input type="email" class="form-control" id="contactEmail" name="email" placeholder="Enter your email" required></div></div>
                                <div class="col-md-6"><div class="mb-3"><label for="phone" class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number"></div></div>
                            </div>
                            <div class="mb-3"><label for="message" class="form-label">Your Message</label><textarea class="form-control" id="message" name="message" rows="5" placeholder="Tell us about your farming challenges or how we can help you..." required></textarea></div>
                            <button type="submit" class="btn btn-submit">Send Message</button>
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
@endsection
