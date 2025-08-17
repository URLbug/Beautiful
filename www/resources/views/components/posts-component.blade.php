<div class="text-center d-flex align-items-center flex-column">
    @foreach($posts as $post)
        @php
            $user = $post->user()->first();
            $isLike = $post->like()->where('user_id', auth()->user()->id)->first();
        @endphp
        <div class="row">
            <div class="card responsive-element mb-5 detail-hover" style="width: 45rem">
                <div class="card-body">
                    <div class="d-flex align-items-center gap-2">
                        @if($user->picture)
                            <img src="{{ $user->picture }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @else
                            <img src="{{ asset('img/none-avatar.png') }}" alt="Avatar" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                        @endif
                        <span class="fw-bold">
                            <a href="{{ route('profile.home', ['username' => $user->username,]) }}" class="text-decoration-none text-black">
                                {{ $user->username }}
                            </a>
                        </span>

                        <i class="fa-solid fa-ellipsis-vertical"></i>

                        <span>
                            {{ $post->created_at->format('Y-m-d H:i') }}
                        </span>
                    </div>

                    <div>
                        <a href="{{ route('profile.posts', ['id' => $post->id]) }}" class="text-decoration-none text-black">
                            <div class="text-start">
                                <h4>{{ $post->name }}</h4>
                                <p class="card-text">{{ strlen($post->description) > 1300 ? substr($post->description, 0, 1300) . '...' : $post->description }}</p>
                            </div>

                            @if(isset($post->file))
                                <div class="rounded-3 mt-2 mb-2">
                                    <img class="card-img-top" src="{{ $post->file }}" alt="Card image {{ $post->name }}">
                                </div>
                            @endif
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-sm">
                            <form method="POST" data-like="like-form-{{ $post->id }}" data-action="{{ route('profile.posts', ['id' => $post->id]) }}">
                                @csrf
                                @method('POST')
                                <input type="hidden" id="id-form" value="like-form-{{ $post->id }}">
                                <button class="btn-unstyled {{ $isLike !== null ? 'text-primary' : '' }}" id="likes-{{ $post->id }}">
                                    <i class="fa-solid fa-heart"></i> {{ count($post->like) }} Like
                                </button>
                            </form>
                        </div>

                        <div class="col-sm">
                            <a href="{{ route('profile.posts', ['id' => $post->id]) }}" class="btn-unstyled text-decoration-none">
                                <i class="fa-solid fa-comment"></i> {{ count($post->comment->toArray()) }} Comment
                            </a>
                        </div>

                        <div class="col-sm">
                            <input type="hidden" id="in0{{ $post->id }}" value="{{ route('profile.posts', ['id' => $post->id]) }}" readonly>
                            <button class="btn-unstyled js-share" data-clipboard-target="#in0{{ $post->id }}"><i class="fa-solid fa-share"></i> Share</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
