<?php

namespace App\Modules\Profile\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Models\User;
use App\Modules\Profile\Models\Follower;
use App\Modules\Profile\Repository\FollowerRepository;
use App\Modules\S3Storage\Lib\S3Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

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

        if($request->isMethod('POST')) {
            return $this->store($username);
        }

        $user = User::query()
        ->where('username', $username);

        if(!$user->exists()) {
            abort(404);
        }

        $user = $user->first();

        return view('profile', [
            'username' => $username,
            'user' => $user,
            'posts' => $user->post()->orderByDesc('posts.id')->get(),
            'followers' => FollowerRepository::getByFollowers($user->id),
            'following' => FollowerRepository::getByFollowing($user->id),
            'isFollower' => FollowerRepository::getFirst($user->id, false),
        ]);
    }

    function store(string $username): RedirectResponse
    {
        $user = User::query()
        ->where('username', $username);

        if(!$user->exists()) {
            return back()->withErrors("User $username not found");
        }

        $follower = FollowerRepository::getFirst($user->first()->id, auth()->user()->id);
        if($follower !== null) {
            return $this->unflower($username);
        }

        $isSave = FollowerRepository::save([
            'follower_id' => auth()->user()->id,
            'following_id' => $user->first()->id,
        ]);

        if($isSave) {
            return back()->with('success', "Follower $username successfully");
        }

        return back()->withErrors("Something went wrong");
    }

    function unflower(string $username): RedirectResponse
    {
        $user = User::query()
        ->where('username', $username);

        $follower = FollowerRepository::getFirst($user->first()->id, auth()->user()->id);
        if($follower->isDirty()) {
            return back()->with('success', "Unfollow $username successfully");
        }

        $isRemove = FollowerRepository::remove([
            'following_id' => auth()->user()->id,
            'follower_id' => $user->first()->id,
        ]);

        if($isRemove) {
            return back()->with('success', "Unfollow $username successfully");
        }

        return back()->withErrors("Something went wrong");
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
