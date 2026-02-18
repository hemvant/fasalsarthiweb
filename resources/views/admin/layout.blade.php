<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <style>
        :root {
            --admin-primary: #2d5f3f;
            --admin-primary-dark: #1e4029;
            --admin-sidebar-bg: #1a1a1a;
            --admin-sidebar-text: rgba(255,255,255,0.85);
        }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f4f6f9; }
        .admin-sidebar {
            background: var(--admin-sidebar-bg);
            min-height: 100vh;
            color: var(--admin-sidebar-text);
        }
        .admin-sidebar .nav-link {
            color: var(--admin-sidebar-text);
            padding: 0.75rem 1.25rem;
            border-left: 3px solid transparent;
        }
        .admin-sidebar .nav-link:hover, .admin-sidebar .nav-link.active {
            color: #fff;
            background: rgba(255,255,255,0.08);
            border-left-color: var(--admin-primary);
        }
        .admin-brand {
            padding: 1.25rem;
            font-weight: 700;
            color: #fff;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-header {
            background: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            padding: 0.75rem 1.5rem;
        }
        .btn-admin { background: var(--admin-primary); color: #fff; border: none; }
        .btn-admin:hover { background: var(--admin-primary-dark); color: #fff; }
        .card { border: none; box-shadow: 0 1px 3px rgba(0,0,0,0.08); border-radius: 10px; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="d-flex">
        <aside class="admin-sidebar" style="width: 240px;">
            <div class="admin-brand">
                <i class="fas fa-leaf me-2"></i> Admin Panel
            </div>
            <nav class="nav flex-column py-2">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">
                    <i class="fas fa-cog me-2"></i> Site Settings
                </a>
                <a class="nav-link {{ request()->routeIs('admin.crop-categories.*') ? 'active' : '' }}" href="{{ route('admin.crop-categories.index') }}">
                    <i class="fas fa-folder me-2"></i> Crop Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.crops.*') ? 'active' : '' }}" href="{{ route('admin.crops.index') }}">
                    <i class="fas fa-seedling me-2"></i> Crops
                </a>
                <a class="nav-link {{ request()->routeIs('admin.scheme-categories.*') ? 'active' : '' }}" href="{{ route('admin.scheme-categories.index') }}">
                    <i class="fas fa-folder me-2"></i> Scheme Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.schemes.*') ? 'active' : '' }}" href="{{ route('admin.schemes.index') }}">
                    <i class="fas fa-file-alt me-2"></i> Schemes
                </a>
                <a class="nav-link {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}" href="{{ route('admin.blog-categories.index') }}">
                    <i class="fas fa-folder me-2"></i> Blog Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.blog-posts.*') ? 'active' : '' }}" href="{{ route('admin.blog-posts.index') }}">
                    <i class="fas fa-blog me-2"></i> Blog Posts
                </a>
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <i class="fas fa-file-contract me-2"></i> Terms & Privacy
                </a>
                <a class="nav-link {{ request()->routeIs('admin.irrigation-categories.*') ? 'active' : '' }}" href="{{ route('admin.irrigation-categories.index') }}">
                    <i class="fas fa-folder me-2"></i> Irrigation Categories
                </a>
                <a class="nav-link {{ request()->routeIs('admin.irrigation-methods.*') ? 'active' : '' }}" href="{{ route('admin.irrigation-methods.index') }}">
                    <i class="fas fa-tint me-2"></i> Irrigation Methods
                </a>
                <hr class="my-2 border-secondary">
                <span class="px-3 small text-muted text-uppercase">Farmer Community</span>
                <a class="nav-link {{ request()->routeIs('admin.community.experts.*') ? 'active' : '' }}" href="{{ route('admin.community.experts.index') }}"><i class="fas fa-user-graduate me-2"></i> Experts</a>
                <a class="nav-link {{ request()->routeIs('admin.community.posts.*') ? 'active' : '' }}" href="{{ route('admin.community.posts.index') }}"><i class="fas fa-comments me-2"></i> Posts</a>
                <a class="nav-link {{ request()->routeIs('admin.community.reports.*') ? 'active' : '' }}" href="{{ route('admin.community.reports.index') }}"><i class="fas fa-flag me-2"></i> Reports</a>
                <a class="nav-link {{ request()->routeIs('admin.community.problem-categories.*') ? 'active' : '' }}" href="{{ route('admin.community.problem-categories.index') }}"><i class="fas fa-tags me-2"></i> Problem Categories</a>
                <a class="nav-link {{ request()->routeIs('admin.community.users.*') ? 'active' : '' }}" href="{{ route('admin.community.users.index') }}"><i class="fas fa-users me-2"></i> Users</a>
                <a class="nav-link {{ request()->routeIs('admin.community.articles.*') ? 'active' : '' }}" href="{{ route('admin.community.articles.index') }}"><i class="fas fa-newspaper me-2"></i> Expert Articles</a>
                <a class="nav-link mt-2" href="{{ url('/') }}" target="_blank">
                    <i class="fas fa-external-link-alt me-2"></i> View Site
                </a>
                <hr class="my-2 border-secondary">
                <form method="POST" action="{{ route('admin.logout') }}" class="px-3">
                    @csrf
                    <button type="submit" class="nav-link w-100 text-start border-0 bg-transparent text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </button>
                </form>
            </nav>
        </aside>
        <div class="flex-grow-1">
            <header class="admin-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 text-dark">@yield('header', 'Dashboard')</h5>
                <span class="text-muted small">{{ auth()->guard('admin')->user()->name ?? 'Admin' }}</span>
            </header>
            <main class="p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof jQuery !== 'undefined' && jQuery.fn.summernote) {
            jQuery('textarea.summernote').each(function() {
                var placeholder = jQuery(this).attr('placeholder') || '';
                var minHeight = jQuery(this).attr('rows') ? Math.max(120, jQuery(this).attr('rows') * 24) : 200;
                jQuery(this).summernote({
                    placeholder: placeholder,
                    tabsize: 2,
                    height: minHeight,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            });
        }
    });
    </script>
    @stack('scripts')
</body>
</html>
