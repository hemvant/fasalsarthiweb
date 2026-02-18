<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --primary-green: #2d5f3f; --light-green: #3d7a52; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2d5f3f 0%, #3d7a52 100%);
        }
        .login-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
            overflow: hidden;
        }
        .login-header {
            background: var(--primary-green);
            color: white;
            padding: 1.5rem 2rem;
            text-align: center;
        }
        .login-header h1 { font-size: 1.5rem; margin: 0; font-weight: 600; }
        .login-header p { margin: 0.25rem 0 0; opacity: 0.9; font-size: 0.9rem; }
        .btn-login {
            background: var(--primary-green);
            color: white;
            padding: 0.6rem 1.5rem;
            font-weight: 600;
            border: none;
            border-radius: 8px;
        }
        .btn-login:hover { background: var(--light-green); color: white; }
        .form-control:focus { border-color: var(--primary-green); box-shadow: 0 0 0 0.2rem rgba(45, 95, 63, 0.25); }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card login-card">
                    <div class="login-header">
                        <i class="fas fa-leaf fa-2x mb-2"></i>
                        <h1>Admin Login</h1>
                        <p>FasalSarthi Admin Panel</p>
                    </div>
                    <div class="card-body p-4">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $err)
                                    <div>{{ $err }}</div>
                                @endforeach
                            </div>
                        @endif
                        <form method="POST" action="{{ route('admin.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg"
                                       value="{{ old('email') }}" required autofocus autocomplete="email"
                                       placeholder="admin@example.com">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg"
                                       required autocomplete="current-password" placeholder="••••••••">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                            <button type="submit" class="btn btn-login w-100 btn-lg">Sign in</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
