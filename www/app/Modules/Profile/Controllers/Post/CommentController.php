<?php

namespace App\Modules\Profile\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Modules\Profile\Models\Comment;
use App\Modules\Profile\Models\Like;
use App\Modules\Profile\Repository\CommentRepository;
use App\Modules\Profile\Repository\LikeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    function index(int $id, Request $request): RedirectResponse|JsonResponse
    {
        if($request->isMethod('POST'))
        {
            if($id !== 0 && $request->ajax())
            {
                return $this->store($request, $id);
            }

            return $this->store($request);
        }

        return back();
    }

    function store(Request $request, ?int $id = null): RedirectResponse|JsonResponse
    {
        if($id !== null) {
            return $this->like($id);
        }

        return $this->create($request);
    }

    function create(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'text' => 'required|string|max:250',
            'post' => 'required|numeric|not_in:0|min:0'
        ]);

        $data = [
            'post_id' => (int)$data['post'],
            'description' => $data['text'],
            'user_id' => auth()->user()->id,
        ];

        if(!CommentRepository::save($data)) {
            return back()->withErrors('Comment could not be created');
        }

        return back()->with('success', "Comment created");
    }

    function like(int $id): JsonResponse
    {
        $like = LikeRepository::getLikesByComment($id, auth()->user()->id);
        if(isset($like) && !$like->isDirty()) {
            return $this->unLike($id, $like->id);
        }

        $data = [
            'comment_id' => $id,
            'user_id' => auth()->user()->id,
        ];

        if(!LikeRepository::save($data)) {
            return response(status: 500)->json([
                'message' => "Like could not be created",
                'status' => 500
            ]);
        }

        return response()->json([
            'id' => $id,
            'likes' => CommentRepository::getById($id)->like()->count(),
            'code' => 200,
        ]);
    }

    function unLike(int $commentId, int $likeId): JsonResponse
    {
        $isRemove = LikeRepository::remove(['id' => $likeId,]);
        if(!$isRemove) {
            return response(status: 500)->json([
                'message' => 'Remove failed',
                'status' => 500,
            ]);
        }

        return response()->json([
            'id' => $commentId,
            'likes' => CommentRepository::getById($commentId)->like()->count(),
            'code' => 200,
        ]);
    }
}
