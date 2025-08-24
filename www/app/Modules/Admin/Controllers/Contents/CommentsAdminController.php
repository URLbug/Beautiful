<?php

namespace App\Modules\Admin\Controllers\Contents;

use App\Modules\Admin\Controllers\Controller;
use App\Modules\Profile\Models\Comment;
use App\Modules\Profile\Repository\CommentRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class CommentsAdminController extends Controller
{

    public function index(Request $request, array $data = []): View|RedirectResponse
    {
        $data = $this->getData($request, 'comments', (new CommentRepository));

        $result = parent::index($request, $data);
        if($result) {
            return $result;
        }

        $comment = new Comment;
        $contents = $this->getContents($comment);

        return view('admin.content.index', [
            'fillables' => $this->getFillables($comment),
            'contents' => $contents,
            'currentPage' => $contents->currentPage(),
            'lastPage' => $contents->lastPage(),
            'route' => 'admin.comments',
        ]);
    }

    private function getFillables(Comment $comment): array
    {
        $fillables = $comment->getFillable();
        $fillables = array_merge(['id',], $fillables);
        $fillables = array_merge($fillables, ['created_at', 'updated_at']);

        return $fillables;
    }

    private function getContents(Comment $comment): LengthAwarePaginator
    {
        return $comment->limit(20)
            ->paginate();
    }
}
