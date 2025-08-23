<?php

namespace App\Modules\Admin\Controllers;

use App\Modules\Master\Repository\UserRepository;
use App\Modules\Profile\Repository\CommentRepository;
use App\Modules\Profile\Repository\PostRepository;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index(Request $request, array $data = []): View
    {
        return view('admin.index', [
            'usersCount' => Cache::remember('users_count', 60, fn () => UserRepository::getAll()->count()),
            'postsCount' => Cache::remember('posts_count', 60, fn () => PostRepository::getAll()->count()),
            'commentCount' => Cache::remember('comments_count', 60, fn () => CommentRepository::getAll()->count()),
        ]);

    }
}
