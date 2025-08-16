<?php

namespace App\Http\Controllers\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class CommentController extends Controller
{
    function index(int $id, Request $request): RedirectResponse|JsonResponse
    {
        if($request->isMethod('POST'))
        {   
            if($id !== 0 && $request->ajax())
            {
                return $this->storeLike($id);
            }

            return $this->storeComment($request);
        }

        return back();
    }

    function getComment($id): ?Comment
    {
        $comment = Comment::query()
        ->where('id', $id);

        if(isset($comment))
        {
            return $comment->first();
        }

        return null;
    }

    function storeComment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'text' => 'required|string|max:250',
            'post' => 'required|numeric|not_in:0|min:0'
        ]);

        $comment = new Comment;

        $comment->user_id = auth()->user()->id;
        $comment->post_id = $data['post'];
        $comment->description = $data['text'];

        $comment->save();

        return back();
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
        ->where('comment_id', $id)
        ->where('user_id', auth()->user()->id)
        ->delete();

        return response()->json([
            'id' => $id,
            'likes' => count($this->getComment($id)->like->toArray()),
            'code' => 200,
        ]);
    }
    
    function storeLike(int $id): JsonResponse 
    {
        $like = $this->isLike($id);

        if(isset($like))
        {
            return $this->unLike($id);
        }

        $like = new Like;

        $like->comment_id = $id;
        $like->user_id = auth()->user()->id;

        $like->save();

        return response()->json([
            'id' => $id,
            'likes' => count($this->getComment($id)->like->toArray()),
            'code' => 200,
        ]);;
    }

    private function isLike(int $id): ?Like
    {
        $like = Like::query()
        ->where('comment_id', $id)
        ->where('user_id', auth()->user()->id)
        ->first();

        return $like;
    }
}
