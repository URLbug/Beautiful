<!DOCTYPE html>
<html lang="{{ Lang::locale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>FurryNet</title>
    <!-- CSS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
    
    <!-- CSS end -->
</head>
<body>
      <!-- header -->
      <header>
        <!-- menu -->
        <div class="main-menu" id="navbar">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}"><i class="fa-brands fa-wolf-pack-battalion"></i> FurryNet</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                            </li>
                            
                            {{-- For auto users want display images and other categories --}}
                            
                            @if(Auth::check())
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ route('posts') }}">Posts</a>
                              </li>
                              </li>
                            @else
                            {{-- end comments --}}

                              <li class="nav-item">
                                  <a class="nav-link" href="{{ route('login') }}">Log In</a>
                              </li>
                              <li class="nav-item">
                                  <a class="nav-link" href="{{ route('regs') }}">Register</a>
                              </li>
                            @endif
                        </ul>
                        
                        {{-- The `search` should also be displayed for auth. users --}}
                        @if(Auth::check())
                          <div class="d-flex justify-content-xl-around">
                            <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#makePost">
                              <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            
                            <form action="{{ route('search') }}" method="POST" class="p-2 d-flex">
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
        </div>
        <!-- menu end -->
    </header>
    <!-- header end -->

    <main>
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
                      <form action="{{ route('posts') }}" method="post" enctype="multipart/form-data">
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

    <br>
    <br>
    <br>

    <footer class="text-center bg-body-tertiary">
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
        © 2024 Copyright:
        <a class="text-body" href="#">FurryNet.com</a>
      </div>
      <!-- Copyright -->
    </footer>
   
    <!-- JS -->
    <!-- JS end -->
</body>
</html>