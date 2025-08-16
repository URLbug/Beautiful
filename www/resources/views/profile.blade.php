@extends('app.app')

@section('content')
    <div class="container">
        <div class="main-body">
        
                <div class="row gutters-sm">
                <div class="col-md-4 mb-3">
                    <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                        @if(!isset($user->picture))
                            <img src="{{ asset('/img/none-avatar.png') }}" class="rounded-circle" width="150">
                        @else
                            <img src="{{ $user->picture }}" alt="" class="rounded-circle" width="150">
                        @endif
                        <div class="mt-3">
                            <h4>{{ $username }}</h4>
                            <p class="text-secondary mb-1">Followers: {{ count($followers->toArray()) }}</p>
                            <p class="text-muted font-size-sm">Following: {{ count($following->toArray()) }}</p>

                            @if(Auth::user()->username === $username)
                                <a class="btn btn-outline-primary" href="{{ route('logout') }}">Logout</a>
                            @else
                                <form action="{{ route('profile', ['username' => $username]) }}" method="post">
                                    @csrf
                                    
                                    @if($isFollower === null)
                                        <button class="btn btn-primary">Follow</button>
                                    @else
                                        <button class="btn btn-primary">Unfollow</button>
                                    @endif
                                </form>
                            @endif
                        </div>
                        </div>
                    </div>
                    </div>
                    
                </div>
                <div class="col-md-8">
                    <div class="card mb-3">
                    <div class="card-body">
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">About Me:</h6>
                        </div>
                        </div>
                        <div class="row">
                        <div class="col-sm-9 text-secondary">
                            @if(isset($user->description))
                                {{ $user->description }}
                            @else
                                No description available.
                            @endif
                        </div>
                        </div>
                        <hr>
                        <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">My Socialnetwork:</h6>
                        </div>
                        </div>
                        @if(isset($user->socialnetworks))
                            <div class="row">
                                <div class="col-sm-3">
                                    @foreach ($user->socialnetworks as $key => $val)
                                        @if(isset($val))
                                            @switch($key)
                                                @case('patreon')
                                                    <a href="{{ $val }}" class="btn group-idk"><i class="fa-brands fa-patreon"></i> Patreon</a>
                                                    
                                                    @break
                                                @case('github')
                                                    <a href="{{ $val }}" class="btn group-idk"><i class="fa-brands fa-github"></i> Github</a>
                                                    
                                                    @break
                                                @case('discord')
                                                    <a href="{{ $val }}" class="btn group-idk"><i class="fa-brands fa-discord"></i> Discord</a>
                                                    
                                                    @break
                                                @case('twitter')
                                                    <a href="{{ $val }}" class="btn group-idk"><i class="fa-brands fa-twitter"></i> Twitter</a>
                                                    
                                                    @break
                                                @case('tiktok')
                                                    <a href="{{ $val }}" class="btn group-idk"><i class="fa-brands fa-tiktok"></i> TikTok</a>

                                                    
                                                    @break
                                                    
                                            @endswitch
                                        @endif                                  
                                    @endforeach
                                </div>
                            </div>
                        @else
                            Not socialnetworks.
                        @endif

                            @if($username === Auth::user()->username)
                                    <hr>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit">Edit</button>
                                        </div>
                                    </div>
                            @endif
                        </div>

                    </div>
                    <!-- Posts -->
                        <x-posts-component :posts="$posts"/>

                        @if($username === Auth::user()->username)
                            <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit profile</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="text-center">
                                        <form action="{{ route('profile', ['username' => $username]) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">
                                                <p>Picture</p>
                                                <input type="file" accept="image/*" name="picture">
                                            </div>

                                        <div class="row">
                                            <p>About Me:</p>
                                            <textarea name="description" id="">
                                                {{ $user->description }}
                                            </textarea>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <p>Socialnetworks:</p>
                                                <p>Patreon: <input type="text" value="{{ isset($user->socialnetworks['patreon']) ? $user->socialnetworks['patreon'] : null }}" name="patreon" id=""></p>
                                                <p>GitHub: <input type="text" value="{{ isset($user->socialnetworks['github']) ? $user->socialnetworks['github'] : null }}"  name="github" id=""></p>
                                                <p>Discord: <input type="text" value="{{ isset($user->socialnetworks['discord']) ? $user->socialnetworks['discord'] : null }}" name="discord" id=""></p>
                                                <p>Twitter: <input type="text" value="{{ isset($user->socialnetworks['twitter']) ? $user->socialnetworks['twitter'] : null }}" name="twitter" id=""></p>
                                                <p>TikTok: <input type="text" value="{{ isset($user->socialnetworks['tiktok']) ? $user->socialnetworks['tiktok'] : null }}" name="tiktok" id=""></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                </div>
                                </div>
                            </div>
                            </div>
                        @endif
                    
                    
                    </div>

                    <!-- Posts end -->
                
                </div>
            </div>
            

        </div>
    </div>
@endsection