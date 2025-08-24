<?php

namespace App\Modules\Admin\Controllers\Contents;

use App\Modules\Admin\Controllers\Controller;
use App\Modules\Master\Models\User;
use App\Modules\Master\Repository\UserRepository;
use App\Modules\Profile\Models\Post;
use App\Modules\Profile\Repository\PostRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class PostsAdminController extends Controller
{

    public function index(Request $request, array $data = []): View|RedirectResponse
    {
        $data = $this->getData($request, 'posts', (new PostRepository));

        $result = parent::index($request, $data);
        if($result) {
            return $result;
        }

        $post = new Post;
        $contents = $this->getContents($post);

        return view('admin.content.index', [
            'fillables' => $this->getFillables($post),
            'contents' => $contents,
            'currentPage' => $contents->currentPage(),
            'lastPage' => $contents->lastPage(),
            'route' => 'admin.posts'
        ]);
    }

    private function getFillables(Post $post): array
    {
        $fillables = $post->getFillable();
        $fillables = array_merge(['id',], $fillables);
        $fillables = array_merge($fillables, ['created_at', 'updated_at']);

        return $fillables;
    }

    private function getContents(Post $post): LengthAwarePaginator
    {
        return $post
            ->limit(20)
            ->paginate();
    }
}
