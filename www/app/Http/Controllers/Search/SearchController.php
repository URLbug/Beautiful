<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        return view('posts.posts', [
            'posts' => $this->store($request),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return LengthAwarePaginator
     */
    public function store(Request $request): LengthAwarePaginator
    {
        $data = $request->validate([
            'search' => 'string|max:255'
        ]);

        return Post::query()
        ->where('description', 'like', $data['search'] . '%')
        ->orWhere('name', 'like', $data['search'] . '%')
        ->paginate();
    }
}
