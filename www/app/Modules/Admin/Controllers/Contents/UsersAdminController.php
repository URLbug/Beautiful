<?php

namespace App\Modules\Admin\Controllers\Contents;

use App\Modules\Admin\Controllers\Controller;
use App\Modules\Master\Models\User;
use App\Modules\Master\Repository\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class UsersAdminController extends Controller
{

    public function index(Request $request, array $data = []): View|RedirectResponse
    {
        $data = $this->getData($request, 'users', (new UserRepository));

        $result = parent::index($request, $data);
        if($result instanceof View) {
            return $result;
        }

        $user = new User;
        $contents = $this->getContents($user);

        return view('admin.content.index', [
            'fillables' => $this->getFillables($user),
            'contents' => $contents,
            'currentPage' => $contents->currentPage(),
            'lastPage' => $contents->lastPage(),
            'route' => 'admin.users'
        ]);
    }

    private function getFillables(User $user): array
    {
        $fillables = $user->getFillable();
        $fillables = array_merge(['id',], $fillables);
        $fillables = array_merge($fillables, ['created_at', 'updated_at']);

        return $fillables;
    }

    private function getContents(User $user): LengthAwarePaginator
    {
        return $user
            ->limit(20)
            ->paginate();
    }
}
