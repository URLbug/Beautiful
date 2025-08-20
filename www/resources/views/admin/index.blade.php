@extends('app.admin')

@section('content')
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Количество пользователей</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Количество активных услуг</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm">
            <div class="text-3xl font-bold text-blue-700 mb-2"></div>
            <div class="text-gray-500">Количество активных новостей</div>
        </div>
    </div>
@endsection
