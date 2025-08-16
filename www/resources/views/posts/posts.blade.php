@extends('app.app')

@section('content')
    <br>
    

    <x-posts-component :posts="$posts"/>

    <div class="d-flex justify-content-around">
        @if($posts->currentPage() !== 1)
        <a class="btn btn-primary" href="{{ route('posts', [
            'page' => $posts->currentPage() - 1
        ]) }}">Back</a>
        @endif

        @if($posts->currentPage() !== $posts->lastPage())
            <a class="btn btn-primary" href="{{ route('posts', [
                'page' => $posts->currentPage() + 1
            ]) }}">Next</a>
        @endif
    </div>
@endsection