@extends('app.app')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Beautiful</h1>
                    <p class="lead mb-4">A modern social network designed for connection and sharing</p>
                    <div class="d-flex justify-content-center gap-3">
                        <span class="badge bg-light text-dark fs-6 p-2">Portfolio Project</span>
                        <span class="badge bg-light text-dark fs-6 p-2">Demonstration Only</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <!-- About Project Section -->
        <section class="mb-5">
            <h2 class="section-title">About Project</h2>
            <div class="row">
                <div class="col-lg-6">
                    <p class="lead">Beautiful is an elegant social network created as a demonstration project for a portfolio. The platform embodies a modern approach to online communication, combining an intuitive interface with powerful functionality.</p>
                </div>
                <div class="col-lg-6">
                    <p>The project was developed by Timur Davydov to showcase full-stack development skills, user interface design, and the creation of complex web applications. Every element of the platform is carefully thought out and implemented with attention to detail.</p>
                </div>
            </div>
        </section>

        <!-- Key Features Section -->
        <section class="mb-5">
            <h2 class="section-title">Key Features</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-person-circle fs-1"></i>
                            </div>
                            <h5 class="card-title">Personal Profiles</h5>
                            <p class="card-text">Create and customize your profile with privacy settings and personal information.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-image fs-1"></i>
                            </div>
                            <h5 class="card-title">Media Sharing</h5>
                            <p class="card-text">Share text, photos, and videos with your network and the wider community.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-chat-dots fs-1"></i>
                            </div>
                            <h5 class="card-title">Comments & Reactions</h5>
                            <p class="card-text">Interact with content through comments and a variety of reaction options.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="card feature-card h-100">
                        <div class="card-body">
                            <div class="text-primary mb-3">
                                <i class="bi bi-collection-play fs-1"></i>
                            </div>
                            <h5 class="card-title">Personalized Feed</h5>
                            <p class="card-text">Enjoy content tailored to your interests with our smart recommendation system.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Technical Information Section -->
        <section class="mb-5">
            <h2 class="section-title">Technical Information</h2>
            <div class="row">
                <div class="col-lg-6">
                    <p>The Beautiful social network is built using modern web development technologies. The project demonstrates a professional approach to code organization, application architecture, and user interface implementation.</p>
                    <p>It's important to note that Beautiful is a demonstration project created exclusively for portfolio purposes and is not intended for commercial use or storage of real users' personal data.</p>
                </div>
                <div class="col-lg-6">
                    <h5>Technologies Used:</h5>
                    <div class="d-flex flex-wrap mt-3">
                        <span class="tech-badge">HTML5</span>
                        <span class="tech-badge">CSS3</span>
                        <span class="tech-badge">JavaScript</span>
                        <span class="tech-badge">Bootstrap 5</span>
                        <span class="tech-badge">PHP 8.4</span>
                        <span class="tech-badge">Laravel 11</span>
                        <span class="tech-badge">PostgreSQL</span>
                        <span class="tech-badge">Redis</span>
                        <span class="tech-badge">AWS S3</span>
                        <span class="tech-badge">Docker</span>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <div class="text-center">
                <div class="">
                    <div class="bg-light rounded-circle p-3 d-inline-block">
                        <i class="bi bi-person-bounding-box text-primary" style="font-size: 3rem;"></i>
                    </div>
                    <h5 class="mt-3">Timur Davydov</h5>
                    <p class="text-muted">Full-Stack Developer</p>
                </div>
            </div>
        </section>
    </div>
    <style>
        .tech-badge {
            background: #e9ecef;
            color: #495057;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            margin: 0.25rem;
            display: inline-block;
            font-size: 0.9rem;
        }
    </style>
@endsection
