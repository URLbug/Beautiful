@extends('app.app')

@section('content')
    <section class="vh-100">
        <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-6 col-xl-5 mb-5 d-flex align-items-center justify-content-center">
                <div class="image-container position-relative">
                    <img
                        src="{{ asset('img/login.png') }}"
                        class="img-fluid rounded-4 shadow-lg"
                        alt="Modern login interface"
                        style="
                transform: perspective(1000px) rotateY(-5deg);
                border: 3px solid #fff;
                transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
                /*max-width: 800px;*/
            "
                    >
                    <div class="position-absolute top-0 start-0 w-100 h-100 rounded-4"
                         style="
                 z-index: -1;
                 background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
                 transform: rotate(3deg) translateY(15px) scale(0.95);
                 filter: blur(15px);
                 opacity: 0.7;
             ">
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                <div class="mb-5 text-center">
                    <h1>Login you profile</h1>
                </div>
                <form action="{{ route('login') }}" method="POST">
                @csrf
                @method('POST')
                <!-- Email input -->
                <div data-mdb-input-init class="form-outline mb-4">
                <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
                    placeholder="Email..." />
                <label class="form-label" for="form3Example3">Email address</label>
                </div>

                <!-- Password input -->
                <div data-mdb-input-init class="form-outline mb-3">
                <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
                    placeholder="Password..." />
                <label class="form-label" for="form3Example4">Password</label>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                <!-- Checkbox -->
                <div class="form-check mb-0">
                    <input class="form-check-input me-2" name="remember_me" type="checkbox" id="form2Example3" />
                    <label class="form-check-label" for="form2Example3">
                    Remember me
                    </label>
                </div>
                <a href="#!" class="text-body">Forgot password?</a>
                </div>

                <div class="text-center text-lg-start mt-4 pt-2">
                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-lg"
                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="{{ route('auth.registration') }}"
                    class="link-danger">Register</a></p>
                </div>

            </form>
            </div>
        </div>
        </div>
    </section>
@endsection
