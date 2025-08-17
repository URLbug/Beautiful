@extends('app.app')

@section('content')
    @php
        $isLike = $post->like()->where('user_id', auth()->user()->id)->first();
    @endphp
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid rounded-1 mb-2" src="{{ $post->file }}" alt="Post">
                </div>

                <div class="col-md-5">
                    <div>
                        @if($post->user->picture)
                            <img src="{{ $post->user->picture }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="{{ asset('img/none-avatar.png') }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @endif

                        <span class="fw-bold">
                            <a href="{{ route('profile.home', ['username' => $post->user->username,]) }}" class="text-decoration-none text-black">
                                {{ $post->user->username }}
                            </a>
                        </span>
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                        <span>{{ $post->created_at->format('Y-m-d H:i') }}</span>
                    </div>

                    <div class="text-start mt-3">
                        <h2>{{ $post->name }}</h2>
                        <p>{{ $post->description }}</p>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            <form method="POST" data-like="like-form-{{ $post->id }}" data-action="{{ route('profile.posts', ['id' => $post->id]) }}">
                                @csrf
                                @method('POST')
                                <button class="btn-unstyled {{ $isLike ? 'text-primary' : '' }}" id="likes-{{ $post->id }}">
                                    <i class="fa-solid fa-heart"></i> {{ count($post->like) }} Like
                                </button>
                            </form>
                        </div>
                        <div class="col-3">
                            <input type="hidden" id="in01" value="{{ route('profile.posts', ['id' => $post->id]) }}" readonly>
                            <button class="btn-unstyled" id="btn01" data-clipboard-target="#in01">
                                <i class="fa-solid fa-share"></i> Share
                            </button>
                        </div>
                    </div>

                    <div class="container justify-content-center mt-5 border-left border-right">
                        <div class="mb-5">
                            <form action="{{ route('profile.comment', ['id' => 0]) }}" method="POST">
                                @csrf
                                @method('POST')

                                <input type="hidden" name="post" value="{{ $post->id }}">
                                <div class="d-flex justify-content-center pt-3 pb-2">
                                    <textarea type="text" name="text" class="form-control" style="max-height: 200px" placeholder="Comment..."></textarea>
                                </div>
                                <input type="submit" class="btn btn-primary" value="+Add a comment">
                            </form>
                        </div>

                        @foreach($post->comment()->get() as $comment)
                            @php
                               $isLike = $comment->like()->where('user_id', auth()->user()->id)->first();
                            @endphp
                            <div class="d-flex justify-content-center py-2">
                                <div class="flex-grow-1 ms-3 py-4 px-4 border">
                                    <div class="d-flex justify-content-between row">
                                        <div class="col-md-4">
                                            @if($comment->user->picture)
                                                <img src="{{ $comment->user->picture }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('img/none-avatar.png') }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif

                                            <span class="fw-bold">
                                                <a href="{{ route('profile.home', ['username' => $comment->user->username,]) }}" class="text-decoration-none text-black">
                                                    {{ $comment->user->username }}
                                                </a>
                                            </span>
                                        </div>

                                        <div class="mb-2 mt-2">
                                            <span class="text-black">{{ $comment->description }}</span>
                                        </div>

                                        <div class="col-md-3">
                                            <form method="POST" data-like="like-form-{{ $comment->id }}" data-action="{{ route('profile.comment', ['id' => $comment->id]) }}">
                                                @csrf
                                                @method('POST')
                                                <button class="btn-unstyled {{ $isLike !== null ? 'text-primary' : '' }}" id="likes-{{ $comment->id }}">
                                                    <i class="fa-solid fa-heart"></i> {{ count($comment->like) }} Like
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
