<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', $metaDescription ?? '')">
    <title>@yield('title', $siteTitle ?? 'FasalSarthi')@if(!empty($siteTagline)) - {{ $siteTagline }}@else - AI-Powered Farming Assistant @endif</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
    @if(!empty($themeCssVars))
    <style>
        :root {
            @foreach($themeCssVars as $var => $value)
            {{ $var }}: {{ $value }};
            @endforeach
        }
    </style>
    @endif
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                @if(!empty($siteLogo))
                    <img src="{{ $siteLogo }}" alt="{{ $siteTitle ?? 'FasalSarthi' }}" style="height:35px;width:auto;">
                @else
                    <div class="icon"><i class="fas fa-seedling"></i></div>
                @endif
                {{ $siteTitle ?? 'FasalSarthi' }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('feature') ? 'active' : '' }}" href="{{ route('feature') }}">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('scheme*') ? 'active' : '' }}" href="{{ route('scheme.index') }}">Schemes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('crop*') ? 'active' : '' }}" href="{{ route('crop.index') }}">Crops</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('irrigation*') ? 'active' : '' }}" href="{{ route('irrigation.index') }}">Irrigation</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('blog*') ? 'active' : '' }}" href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? '' : '' }}" href="{{ route('home') }}#testimonials">Testimonials</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? '' : '' }}" href="{{ route('home') }}#contact">Contact</a>
                    </li>
                </ul>
                <a class="btn btn-download" href="{{ route('home') }}#contact">Download App</a>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="footer-brand">
                        @if(!empty($siteLogo))
                            <img src="{{ $siteLogo }}" alt="{{ $siteTitle ?? 'FasalSarthi' }}" style="height:35px;width:auto;margin-right:10px;">
                        @else
                            <div class="icon"><i class="fas fa-seedling"></i></div>
                        @endif
                        <h5>{{ $siteTitle ?? 'FasalSarthi' }}</h5>
                    </div>
                    <p>{{ $footerAbout ?? 'Empowering farmers with AI-powered insights, weather predictions, and community support for sustainable agriculture.' }}</p>
                    <div class="social-icons">
                        <a href="{{ $facebookUrl ?? '#' }}"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $twitterUrl ?? '#' }}"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $instagramUrl ?? '#' }}"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $linkedinUrl ?? '#' }}"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-md-2 offset-md-1" data-aos="fade-up" data-aos-delay="100">
                    <div class="footer-links">
                        <h6>Quick Links</h6>
                        <ul>
                            <li><a href="{{ route('feature') }}">Features</a></li>
                            <li><a href="{{ route('scheme.index') }}">Schemes</a></li>
                            <li><a href="{{ route('crop.index') }}">Crops</a></li>
                            <li><a href="{{ route('irrigation.index') }}">Irrigation</a></li>
                            <li><a href="{{ route('blog.index') }}">Blog</a></li>
                            <li><a href="{{ route('home') }}#contact">Contact</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('term') }}">Terms</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2" data-aos="fade-up" data-aos-delay="200">
                    <div class="footer-links">
                        <h6>Contact</h6>
                        <ul>
                            @if(!empty($contactEmail))<li><i class="fas fa-envelope me-2"></i>{{ $contactEmail }}</li>@endif
                            @if(!empty($contactPhone))<li><i class="fas fa-phone me-2"></i>{{ $contactPhone }}</li>@endif
                            @if(!empty($siteAddress))<li><i class="fas fa-map-marker-alt me-2"></i>{{ Str::limit($siteAddress, 40) }}</li>@endif
                            @if(!empty($workingHours))<li><i class="fas fa-clock me-2"></i>{{ $workingHours }}</li>@endif
                            @if(empty($contactEmail) && empty($contactPhone) && empty($siteAddress))<li class="text-muted">Set in Admin → Site Settings</li>@endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer-bottom" data-aos="fade-up">
                <p>© {{ date('Y') }} {{ $siteTitle ?? 'FasalSarthi' }}. All rights reserved. Empowering farmers with AI technology.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ duration: 800, once: true, offset: 100 });
        document.addEventListener('scroll', function () {
            var navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
        document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
            anchor.addEventListener('click', function (e) {
                var id = this.getAttribute('href').slice(1);
                if (!id) return;
                var target = document.getElementById(id);
                if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
