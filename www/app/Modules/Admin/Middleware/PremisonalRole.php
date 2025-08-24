<?php

namespace App\Modules\Admin\Middleware;

use App\Modules\Master\Repository\RoleRepository;
use App\Modules\Master\Repository\UserRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PremisonalRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!auth()->check()) {
            return redirect()->route('auth.login');
        }

        $role = auth()->user()->role()->get();
        $permissions = array_column($role->toArray(), 'permissions');

        if(!in_array(1, $permissions)) {
            return redirect()->route('master.home');
        }

        return $next($request);
    }
}
