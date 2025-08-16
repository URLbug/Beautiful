<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Follower;
use App\Models\User;
use App\Owners\S3Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ProfileController extends Controller
{
    function index(string $username, Request $request): View|RedirectResponse
    {
        if(
            $request->isMethod('PATCH') &&
            $username === auth()->user()->username
        ) {
            return $this->update($request);
        }

        if($request->isMethod('POST'))
        {
            return $this->store($username);
        }

        $user = User::query()
        ->where('username', $username);

        if(!$user->exists())
        {
            abort(404);
        }

        $user = $user->first();

        return view('profile', [
            'username' => $username,
            'user' => $user,
            'posts' => $user->post()->orderByDesc('id')->get(),
            'followers' => Follower::query()
            ->where('following_id', $user->id)
            ->get(['follower_id']),

            'following' => Follower::query()
            ->where('follower_id', $user->id)
            ->get(['following_id']),
            
            'isFollower' => Follower::query()
            ->where('following_id', $user->id)
            ->where('follower_id', auth()->user()->id)
            ->first(),
        ]);
    }

    function store(string $username): RedirectResponse
    {
        $user = User::query()
        ->where('username', $username);
        
        $follower = Follower::query()
        ->where('following_id', $user->first()->id)
        ->where('follower_id', auth()->user()->id)
        ->first();

        if(
            !$user->exists() ||
            $follower !== null
        ) {
            return $this->unflower($username);
        }

        $follower = new Follower;

        $follower->follower_id = auth()->user()->id;
        $follower->following_id = $user->first()->id;

        $follower->save();

        return back();
    }

    function unflower(string $username): RedirectResponse
    {
        $user = User::query()
        ->where('username', $username);
        
        $follower = Follower::query()
        ->where('follower_id', auth()->user()->id);

        if(
            !$user->exists() ||
            $follower->first()->toArray() === []
        ) {
            return back();
        }

        $follower = $follower
        ->where('following_id', $user->first()->id)
        ->delete();

        return back();
    }

    function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'picture' => 'image|max:1004|nullable',
            'description' => 'string|max:255|nullable',
            'patreon' => 'string|url|nullable',
            'github' => 'string|url|nullable',
            'discord' => 'string|url|nullable',
            'twitter' => 'string|url|nullable',
            'tiktok' => 'string|url|nullable',
        ]);

        $user = User::query()
        ->where('username', auth()->user()->username)
        ->first();

        if(isset($data['picture']))
        {
            $picture = $data['picture'];

            if(isset($user->picture))
            {
                if(!S3Storage::deleteFile($user->picture))
                {
                    abort(500);
                }
            }

            if(!S3Storage::putFile('/', $picture))
            {
                abort(500);
            }

            $user->picture = S3Storage::getFile($picture->hashName());
        }

        if(isset($data['description']))
        {
            $user->description = $data['description'];

            unset($data['description']);
        }

        $user->socialnetworks = $data;

        $user->save();

        return back();
    }
}
