<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-light">
<!-- Sidebar -->
<div class="container-fluid">
    <div class="row">
        <aside class="col-md-3 col-lg-2 d-md-block bg-white border-end p-0 position-fixed vh-100">
            <div class="p-4 border-bottom">
                <a href="{{ route('admin.home') }}" class="text-decoration-none">
                    <h2 class="h5 fw-semibold text-primary mb-0">{{ env('APP_NAME') }}</h2>
                </a>
            </div>

            <nav class="p-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a href="{{ route('admin.home') }}" class="nav-link text-dark hover-primary">
                            <i class="fas fa-home fa-fw me-3"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.posts') }}" class="nav-link text-dark hover-primary">
                            <i class="fa-solid fa-bell-concierge fa-fw me-3"></i> Posts
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.comments') }}" class="nav-link text-dark hover-primary">
                            <i class="fa-solid fa-newspaper fa-fw me-3"></i> Comments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users') }}" class="nav-link text-dark hover-primary">
                            <i class="fa-solid fa-comment fa-fw me-3"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('master.home') }}" class="nav-link text-dark hover-primary">
                            <i class="fa-solid fa-right-to-bracket fa-fw me-3"></i> Public home
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="col-md-9 col-lg-10 ms-sm-auto px-md-4 py-4">
            @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="alert alert-danger mb-3" role="alert">
                        <span class="fw-medium"><strong>Error !</strong> {{ $error }}</span>
                    </div>
                @endforeach
            @endif

            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong>Success !</strong> {{ session('success') }}
                </div>
            @endif

            <!-- Top Bar -->
            @if(\Illuminate\Support\Facades\Auth::check() && (isset($exception) && $exception->getStatusCode() < 400))
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2 fw-semibold text-dark">@yield('title')</h1>
                    <a href="{{ route('logout') }}" class="btn btn-primary btn-sm">
                        Выйти
                    </a>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
