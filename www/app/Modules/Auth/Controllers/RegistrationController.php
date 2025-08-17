<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Models\User;
use App\Modules\Master\Repository\UserRepository;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    function index(Request $request): View|RedirectResponse
    {
        if($request->isMethod('POST'))
        {
            return $this->store($request);
        }

        return view('auth.regs');
    }

    function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6|string',
        ]);

        $isUser = UserRepository::getByEmail($data['email']);
        if($isUser) {
            return back()->withErrors('User already exists');
        }

        $isSaved = UserRepository::save([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if(!$isSaved) {
            return back()->withErrors('Failed to registration user');
        }

        return redirect()
        ->route('login')
        ->with('success', 'You have successfully register in!');
    }
}
