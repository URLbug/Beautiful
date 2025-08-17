<?php

namespace App\Modules\Profile\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Models\Post;
use App\Modules\Profile\Repository\PostRepository;
use App\Modules\S3Storage\Lib\S3Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class PostController extends Controller
{
    function index(int $id, Request $request): View|JsonResponse|RedirectResponse
    {
        if($id !== 0) {
            if($request->isMethod('POST') && $request->ajax()) {
                return $this->storeLike($id);
            }

            $post = PostRepository::getById($id);
            if(!isset($post)) {
                abort(404);
            }

            return $this->show($post);
        }

        if($request->isMethod('POST')) {
            return $this->store($request);
        }

        $posts = PostRepository::getPagination([$id, 'desc']);
        return $this->show($posts);
    }

    function show(LengthAwarePaginator|Post $post): View
    {
        if($post instanceof LengthAwarePaginator) {
            return view('posts.posts', [
                'posts' => $post,
            ]);
        }

        return view('posts.detail', [
            'post' => $post,
        ]);
    }

    function store(Request $request): RedirectResponse|JsonResponse
    {
        return $this->create($request);
    }

    function create(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'file' => 'image|max:1004',
            'description' => 'string|max:255',
        ]);

        if(!S3Storage::putFile('/', $data['file'])) {
            return back()->withErrors('Create post failed');
        }

        $file = S3Storage::getFile($data['file']->hashName());

        $data = [
            'name' => $data['name'],
            'description' => $data['description'],
            'file' => $file,
        ];

        if(!PostRepository::save($data)) {
            return back()->withErrors('Create post failed');
        }

        return back()->with('success', 'Create new post!');
    }

    function storeLike(int $id): JsonResponse
    {
        $like = $this->isLike($id);

        if(isset($like)) {
            return $this->unLike($id);
        }

        $like = new Like;

        $like->post_id = $id;
        $like->user_id = auth()->user()->id;

        $like->save();

        return response()->json([
            'id' => $id,
            'likes' => PostRepository::getById($id)->like()->count(),
            'code' => 200,
        ]);
    }

    function unLike(int $id): JsonResponse
    {
        $like = $this->isLike($id);

        if(!isset($like))
        {
            return response()->json([
                'message' => 'error',
                'code' => 500,
            ]);
        }

        Like::query()
        ->where('post_id', $id)
        ->where('user_id', auth()->user()->id)
        ->delete();

        return response()->json([
            'id' => $id,
            'likes' => PostRepository::getById($id)->like()->count(),
            'code' => 200,
        ]);
    }

    private function isLike(int $id): RedirectResponse|Like|null
    {
        if($id === 0)
        {
            return back();
        }

        $like = Like::query()
        ->where('post_id', $id)
        ->where('user_id', auth()->user()->id)
        ->first();

        return $like;
    }
}
