@extends('app.admin')

@section('content')
    <div class="row">
        <div class="mb-2 bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Sum users: {{ $usersCount }}</div>
        </div>
        <div class="mb-2 bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Sum posts {{ $postsCount }}</div>
        </div>
        <div class="mb-2 bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Sum comments {{ $commentCount }}</div>
        </div>
    </div>
@endsection
