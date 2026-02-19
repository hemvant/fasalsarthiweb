<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#059669">
    <link rel="manifest" href="{{ asset('expert-manifest.json') }}">
    <title>@yield('title', 'Expert Portal') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/expert-pwa.css') }}">
    @stack('styles')
</head>
<body class="bg-light expert-pwa">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('expert.landing') }}"><i class="fas fa-leaf me-1"></i> Expert Portal</a>
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#expertNav" aria-controls="expertNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="expertNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link {{ request()->routeIs('expert.dashboard') ? 'active' : '' }}" href="{{ route('expert.dashboard') }}"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    <a class="nav-link {{ request()->routeIs('expert.questions.*') ? 'active' : '' }}" href="{{ route('expert.questions.index') }}"><i class="fas fa-users me-1"></i> Community</a>
                    <a class="nav-link {{ request()->routeIs('expert.articles.*') ? 'active' : '' }}" href="{{ route('expert.articles.index') }}"><i class="fas fa-newspaper me-1"></i> Articles</a>
                    <a class="nav-link {{ request()->routeIs('expert.profile.*') ? 'active' : '' }}" href="{{ route('expert.profile.edit') }}"><i class="fas fa-user me-1"></i> Profile</a>
                    <a class="nav-link" href="#" id="expert-install-btn" style="display:none"><i class="fas fa-download me-1"></i> Install app</a>
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#expert-install-help"><i class="fas fa-info-circle me-1"></i> Help</a>
                    <a class="nav-link" href="{{ route('expert.logout') }}" onclick="event.preventDefault(); document.getElementById('expert-logout').submit();"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    <form id="expert-logout" action="{{ route('expert.logout') }}" method="POST" class="d-none">@csrf</form>
                </div>
            </div>
            @endauth
        </div>
    </nav>
    <main class="container py-4">
        @if($errors->any())
        <div class="validation-errors" role="alert">
            <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-check-circle"></i></span>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-times-circle"></i></span>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('message'))
        <div class="alert alert-info alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-info-circle"></i></span>
            <span>{{ session('message') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <span class="alert-icon"><i class="fas fa-exclamation-triangle"></i></span>
            <span>{{ session('warning') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        @yield('content')
    </main>

    <div class="modal fade" id="expert-install-help" tabindex="-1" aria-labelledby="expertInstallHelpLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="expertInstallHelpLabel"><i class="fas fa-mobile-alt me-2"></i>Install Expert Portal app</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    <p class="mb-3">Install this site as an app to open it from your home screen and use it offline.</p>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><strong>Chrome (Android):</strong> Menu (⋮) → <em>Install app</em> or <em>Add to Home screen</em></li>
                        <li class="mb-2"><strong>Chrome (Desktop):</strong> Click the install icon (⊕) in the address bar, or Menu → <em>Install Expert Portal</em></li>
                        <li class="mb-2"><strong>Safari (iPhone/iPad):</strong> Share button → <em>Add to Home Screen</em> → Add</li>
                        <li class="mb-2"><strong>Edge (Desktop):</strong> Menu (⋯) → <em>Apps</em> → <em>Install this site as an app</em></li>
                        <li class="mb-0"><strong>Firefox (Android):</strong> Menu → <em>Install</em></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/expert-sw.js').catch(function() {});
      }
      var expertInstallPrompt;
      window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        expertInstallPrompt = e;
        var btn = document.getElementById('expert-install-btn');
        if (btn) { btn.style.display = 'inline-block'; }
      });
      function expertDoInstall() {
        if (expertInstallPrompt) {
          expertInstallPrompt.prompt();
          expertInstallPrompt.userChoice.then(function(choice) {
            expertInstallPrompt = null;
            var btn = document.getElementById('expert-install-btn');
            if (btn) btn.style.display = 'none';
          });
          return true;
        }
        return false;
      }
      document.getElementById('expert-install-btn') && document.getElementById('expert-install-btn').addEventListener('click', function(e) {
        e.preventDefault();
        expertDoInstall();
      });
      document.getElementById('expert-install-landing-link') && document.getElementById('expert-install-landing-link').addEventListener('click', function(e) {
        e.preventDefault();
        if (!expertDoInstall()) {
          var el = document.getElementById('expert-install-help');
          if (el && window.bootstrap && bootstrap.Modal) bootstrap.Modal.getOrCreateInstance(el).show();
        }
      });
    </script>
    @stack('scripts')
</body>
</html>
