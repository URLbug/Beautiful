<?php

namespace App\Modules\Profile\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Models\Post;
use App\Modules\Profile\Repository\LikeRepository;
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
                return $this->store($request, $id);
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

        $posts = PostRepository::getPagination(['id', 'desc']);
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

    function store(Request $request, ?int $id = null): RedirectResponse|JsonResponse
    {
        if($id === null) {
            return $this->create($request);
        }

        return $this->like($id);
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
        if(!$file) {
            return back()->withErrors('Create post failed');
        }

        $data = [
            'name' => $data['name'],
            'description' => $data['description'],
            'file' => $file,
            'user_id' => auth()->user()->id,
        ];

        if(!PostRepository::save($data)) {
            return back()->withErrors('Create post failed');
        }

        return back()->with('success', 'Create new post!');
    }

    function like(int $id): JsonResponse
    {
        if($id === 0) {
            return response(status: 404)->json([
                'message' => 'Post not found',
                'status' => 404,
            ]);
        }

        $like = LikeRepository::getLikesByPost($id, auth()->user()->id);
        if(isset($like) && !$like->isDirty()) {
            return $this->unLike($id, $like->id);
        }

        $isSave = LikeRepository::save([
            'user_id' => auth()->user()->id,
            'post_id' => $id,
        ]);

        if(!$isSave) {
            return response(status: 500)->json([
                'message' => 'Save failed',
                'status' => 500,
            ]);
        }

        return response()->json([
            'id' => $id,
            'likes' => PostRepository::getById($id)->like()->count(),
            'code' => 200,
        ]);
    }

    function unLike(int $postId, int $likeId): JsonResponse
    {
        $isRemove = LikeRepository::remove(['id' => $likeId,]);
        if(!$isRemove) {
            return response(status: 500)->json([
                'message' => 'Remove failed',
                'status' => 500,
            ]);
        }

        return response()->json([
            'id' => $postId,
            'likes' => PostRepository::getById($postId)->like()->count(),
            'code' => 200,
        ]);
    }
}
