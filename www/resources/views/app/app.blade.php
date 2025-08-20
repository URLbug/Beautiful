<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ env('APP_NAME') }}</title>
    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
</head>
<body>
      <!-- header -->
      <header>
        <!-- menu -->
        <div class="main-menu fixed-top" id="navbar">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('master.home') }}">
                    <i class="fa-brands fa-wolf-pack-battalion"></i> {{ env('APP_NAME') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                            {{-- For auto users want display images and other categories --}}

                            @if(Auth::check())
                                <li class="nav-item">
                                    <a class="nav-link {{ str_contains(url()->current(), '/profile/' . auth()->user()->username) ? 'active' : '' }}" href="{{ route('profile.home', ['username' => auth()->user()->username]) }}">
                                        Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ str_contains(url()->current(), '/posts') ? 'active' : ''}}" href="{{ route('profile.posts') }}">
                                        Posts
                                    </a>
                                </li>
                            @else
                            {{-- end comments --}}

                              <li class="nav-item">
                                  <a class="nav-link {{ str_contains(url()->current(), '/login') ? 'active' : ''}}" href="{{ route('login') }}">
                                      Log In
                                  </a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link {{ str_contains(url()->current(), '/registration') ? 'active' : ''}}" href="{{ route('auth.registration') }}">
                                      Register
                                  </a>
                              </li>
                            @endif
                            <li class="nav-item">
                                <a class="nav-link {{ str_contains(url()->current(), '/about') ? 'active' : ''}}" href="{{ route('master.about') }}">
                                    About
                                </a>
                            </li>
                        </ul>

                        {{-- The `search` should also be displayed for auth. users --}}
                        @if(Auth::check())
                          <div class="d-flex justify-content-xl-around">
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#makePost">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>

                            <form action="{{ route('search.home') }}" method="POST" class="p-2 d-flex">
                                @csrf
                                @method('POST')

                                <input class="form-control me-2" type="search" placeholder="Search" name="search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form>
                          </div>
                        @endif
                        {{-- end comments --}}
                    </div>
                </div>
            </nav>
            @if(Session::has('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <strong>Success !</strong> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Error !</strong> {{ $errors->first() }}
                </div>
            @endif
        </div>
        <!-- menu end -->
    </header>
    <!-- header end -->

    <main class="mt-5" style="padding-bottom: 200px;">
      @yield('content')
    </main>

    @if(Auth::check())
        <div class="modal fade" id="makePost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Create Posts</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                <div class="modal-body">
                    <div class="text-center">
                      <form action="{{ route('profile.posts') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')

                        <div class="row">
                          <p>File</p>
                          <input type="file" name="file" id="file">
                        </div>

                        <div class="row">
                          <p>Name Post</p>
                          <input type="text" name="name" id="name">
                        </div>

                        <div class="row">
                          <p>Description</p>
                          <textarea type="text" name="description" id="description">
                          </textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                            <button type="submit" class="btn btn-primary">Posts</button>
                        </div>
                    </form>
                  </div>
              </div>
                </div>
            </div>
        </div>
    @endif

    <footer class="text-center bg-body-tertiary mt-5">
        <!-- Grid container -->
        <div class="container pt-4">
          <!-- Section: Social media -->
          <section class="mb-4">
            <!-- Facebook -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-facebook-f"></i
            ></a>

            <!-- Twitter -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-twitter"></i
            ></a>

            <!-- Google -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-google"></i
            ></a>

            <!-- Instagram -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-instagram"></i
            ></a>

            <!-- Linkedin -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-linkedin"></i
            ></a>
            <!-- Github -->
            <a
              data-mdb-ripple-init
              class="btn btn-link btn-floating btn-lg text-body m-1"
              href="#!"
              role="button"
              data-mdb-ripple-color="dark"
              ><i class="fab fa-github"></i
            ></a>
          </section>
          <!-- Section: Social media -->
        </div>
        <!-- Grid container -->

    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © {{ date('Y') }} Copyright:
        <a class="text-body" href="#">{{ env('APP_NAME') }}</a>
      </div>
      <!-- Copyright -->
    </footer>
</body>
</html>
