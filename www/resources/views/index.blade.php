@extends('app.app')

@section('content')
    <!-- page title -->
    <div
        class="bg-image d-flex justify-content-center align-items-center main-picture"
        style="
                background-image: url({{ asset('img/home.jpg') }});
                height: 100vh;
                "
        >
        <div class="cover"></div>

        <div class="content">
            <h1 class="text-white"><i class="fa-brands fa-wolf-pack-battalion"></i> Welcome to FurryNet!</h1>
            <h4 class="text-white">Here you can all this</h4>
            <a href="{{ route('regs') }}" class="btn login-a"><i class="fa-solid fa-plus"></i> Join us</a>
            <a href="{{ route('login') }}" class="btn login-a"><i class="fa-solid fa-right-to-bracket"></i> Log in</a>
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
                <p>Here you can share your artworks and see other peoples artworks</p>
                <a href="{{ route('login') }}" class="group-idk">Start artworks</a>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-camera"></i> Photos</h4>
                <p>Here you can share your photos and see other peoples photos</p>
                <a href="{{ route('login') }}" class="group-idk">Start photos</a>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-feather-pointed"></i> Writing</h4>
                <p>Here you can share your writings and see other peoples writings</p>
                <a href="{{ route('login') }}" class="group-idk">Start writing</a>
            </div>
            <div class="col-md-3">
                <h4><i class="fa-solid fa-user-group"></i> Friends</h4>
                <p>Here you can make new friends and talk to them</p>
                <a href="{{ route('login') }}" class="group-idk">Start talking</a>
            </div>
        </div>
    </div>
    <!-- text end -->

    <br>
    <br>
    <br>

@endsection