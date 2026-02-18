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
    @stack('styles')
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: #059669;">
        <div class="container">
            <a class="navbar-brand" href="{{ route('expert.landing') }}">Expert Portal</a>
            @auth
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('expert.dashboard') }}">Dashboard</a>
                <a class="nav-link" href="{{ route('expert.questions.index') }}">Questions</a>
                <a class="nav-link" href="{{ route('expert.articles.index') }}">Articles</a>
                <a class="nav-link" href="{{ route('expert.profile.edit') }}">Profile</a>
                <a class="nav-link" href="#" id="expert-install-btn" style="display:none"><i class="fas fa-download me-1"></i> Install app</a>
                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#expert-install-help"><i class="fas fa-info-circle me-1"></i> Install help</a>
                <a class="nav-link" href="{{ route('expert.logout') }}" onclick="event.preventDefault(); document.getElementById('expert-logout').submit();">Logout</a>
                <form id="expert-logout" action="{{ route('expert.logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
            @endauth
        </div>
    </nav>
    <main class="container py-4">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @if(session('message'))<div class="alert alert-info">{{ session('message') }}</div>@endif
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
        navigator.serviceWorker.register('{{ asset("expert-sw.js") }}').catch(function() {});
      }
      var expertInstallPrompt;
      window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        expertInstallPrompt = e;
        var btn = document.getElementById('expert-install-btn');
        if (btn) { btn.style.display = 'inline-block'; }
      });
      document.getElementById('expert-install-btn') && document.getElementById('expert-install-btn').addEventListener('click', function(e) {
        e.preventDefault();
        if (expertInstallPrompt) {
          expertInstallPrompt.prompt();
          expertInstallPrompt.userChoice.then(function(choice) {
            expertInstallPrompt = null;
            document.getElementById('expert-install-btn').style.display = 'none';
          });
        }
      });
    </script>
    @stack('scripts')
</body>
</html>
