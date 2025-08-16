<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Models\User;
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

        $isUser = User::query()
        ->where('email', $data['email'])
        ->exists();

        if($isUser) {
            return back()->withErrors('User exists');
        }

        $user = new User;

        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->username = $data['username'];

        $user->save();

        return redirect()
        ->route('auth.login')
        ->with('success', 'You have successfully register in!');
    }
}
