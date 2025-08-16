@extends('app.app')

@section('content')
    <div class="container">
        <div class="main-body">
            <div class="row">
                <div class="col-md-6">
                    <img class="img-fluid" src="{{ $post->file }}" alt="">
                </div>

                <div class="col-md-5">
                    <div class="text-center">
                        <h1>{{ $post->name }}</h1>
                    </div>
                    <h5>description:</h4>
                    <p>{{ $post->description }}</p>
                    <div class="user">
                        <div><img src="{{ $post->user->picture }}" width="18"><span class="text2"><a href="{{ route('profile', ['username' => $post->user->username]) }}">{{ $post->user->username }}</a></span></div>
                    </div>

                    <form method="POST" data-like="like-form-{{ $post->id }}" data-action="{{ route('posts', ['id' => $post->id]) }}">
                        @csrf
                        @method('POST')
                        <button class="btn btn-primary" id="likes-{{ $post->id }}"><i class="fa-solid fa-heart"></i>{{ count($post->like) }} Like</button>
                    </form>
                    <input type="hidden" id="in01" value="{{ route('posts', ['id' => $post->id]) }}" readonly>
                    <button class="btn btn-success" id="btn01" data-clipboard-target="#in01"><i class="fa-solid fa-share"></i> Share</button>
                
                    <div class="container justify-content-center mt-5 border-left border-right">
                        <form action="{{ route('comment', ['id' => 0]) }}" method="POST">
                            @csrf
                            @method('POST')

                            <input type="hidden" name="post" value="{{ $post->id }}">
                            <div class="d-flex justify-content-center pt-3 pb-2"> <input type="text" name="text" placeholder="+ Add a note" class="form-control addtxt"> </div>
                        </form>
                        
                        @foreach($post->comment()->get() as $comment)
                            <div class="d-flex justify-content-center py-2">
                                <div class="second py-2 px-2"> <span class="text1">{{ $comment->description }}</span>
                                    <div class="d-flex justify-content-between py-1 pt-2">
                                        <div><img src="{{ $comment->user->picture }}" width="18"><span class="text2"><a href="{{ route('profile', ['username' => $comment->user->username, ]) }}">
                                            {{ $comment->user->username }}
                                        </a></span></div>

                                        <form method="POST" data-like="like-form-{{ $comment->id }}" data-action="{{ route('comment', ['id' => $comment->id]) }}">
                                            @csrf
                                            @method('POST')
                                            <button class="btn btn-primary" id="likes-{{ $comment->id }}"><i class="fa-solid fa-heart"></i>{{ count($comment->like) }} Like</button>
                                        </form>
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