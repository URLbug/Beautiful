<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RegsController extends Controller
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

        $isUser = User::query()
        ->where('email', $data['email'])
        ->exists();

        if($isUser)
        {
            return back()->withErrors('User exists');
        }

        $user = new User;

        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->username = $data['username'];

        $user->save();

        return redirect()
        ->route('login')
        ->with('success', 'You have successfully registed in!');
    }
}
