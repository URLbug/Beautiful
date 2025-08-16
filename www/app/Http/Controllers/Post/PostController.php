<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Post;
use App\Owners\S3Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class PostController extends Controller
{
    function index(int $id, Request $request): View|JsonResponse|RedirectResponse
    {
        if($id !== 0)
        {
            if($request->isMethod('POST') && $request->ajax())
            {
                return $this->storeLike($id);
            }

            $post = $this->getPost($id);

            if(!isset($post))
            {
                abort(404);
            }

            return view('posts.detail_posts', [
                'post' => $post,
            ]);
        }

        if($request->isMethod('POST'))
        {
            return $this->storePost($request);
        }

        $posts = Post::query()
        ->orderByDesc('id')
        ->paginate();

        return view('posts.posts', [
            'posts' => $posts,
        ]);
    }

    function storePost(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'file' => 'image|max:1004',
            'description' => 'string|max:255',
        ]);

        $post = new Post;

        if(!S3Storage::putFile('/', $data['file']))
        {
            abort(500);
        }

        $post->file = S3Storage::getFile($data['file']->hashName());

        $post->name = $data['name'];
        $post->description = $data['description'];
        $post->user_id = auth()->user()->id;

        $post->save();

        return back()->with('success', 'Create new post!');
    }

    function getPost(int $id): ?Post
    {
        $post = Post::query()
        ->where('id', $id);

        if(isset($post))
        {
            return $post->first();
        }

        return null;
    }

    function storeLike(int $id): JsonResponse
    {
        $like = $this->isLike($id);

        if(isset($like))
        {
            return $this->unLike($id);
        }

        $like = new Like;
        
        $like->post_id = $id;
        $like->user_id = auth()->user()->id;

        $like->save();

        return response()->json([
            'id' => $id,
            'likes' => count($this->getPost($id)->like->toArray()),
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
            'likes' => count($this->getPost($id)->like->toArray()),
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
