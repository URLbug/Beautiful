@extends('app.app')

@section('content')
    <!-- page title -->
    <div
        class="bg-image d-flex justify-content-center align-items-center main-picture"
        style="
                background-image: url({{ asset('img/home.jpg') }});
                background-repeat: no-repeat;
                background-size: cover;
                height: 100vh;
                "
        >
        <div class="cover"></div>

        <div class="content">
            <h1 class="text-white"><i class="fa-brands fa-wolf-pack-battalion"></i> Welcome to {{ env('APP_NAME') }}!</h1>
            <h4 class="text-white">Here you can all this</h4>
            @if(auth()->check())
                <a href="{{ route('profile.home', ['username' => auth()->user()->username]) }}" class="btn login-a"><i class="fa-solid fa-right-to-bracket"></i> Go to profile!</a>
            @else
                <a href="{{ route('auth.registration') }}" class="btn login-a"><i class="fa-solid fa-plus"></i> Join us</a>
                <a href="{{ route('login') }}" class="btn login-a"><i class="fa-solid fa-right-to-bracket"></i> Log in</a>
            @endif

        </div>
    </div>
    <!-- page title end -->

    <!-- text -->
    <div class="container text-center">
        <div class="row">
            <div class="col-md-8 offset-md-2 p-5">
                <h2>What will I do here?</h2>
                <h5>Here you will do different artworks and talk to different furries</h5>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-palette"></i> Arts</h4>
                <p>
                    Here you can share your artworks and see other peoples artworks
                    <br>
                    <a href="{{ auth()->check() ? route('profile.home', ['username' => auth()->user()->username]) : route('login') }}" class="group-idk">Start artworks</a>
                </p>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-camera"></i> Photos</h4>
                <p>
                    Here you can share your photos and see other peoples photos
                    <br>
                    <a href="{{ auth()->check() ? route('profile.home', ['username' => auth()->user()->username]) : route('login') }}" class="group-idk">Start photos</a>
                </p>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-feather-pointed"></i> Writing</h4>
                <p>
                    Here you can share your writings and see other peoples writings
                    <br>
                    <a href="{{ auth()->check() ? route('profile.home', ['username' => auth()->user()->username]) : route('login') }}" class="group-idk">Start writing</a>
                </p>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-user-group"></i> Friends</h4>
                <p>
                    Here you can make new friends and talk to them
                    <br>
                    <a href="{{ auth()->check() ? route('profile.home', ['username' => auth()->user()->username]) : route('login') }}" class="group-idk">Start talking</a>
                </p>
            </div>
        </div>
    </div>
    <!-- text end -->

@endsection
