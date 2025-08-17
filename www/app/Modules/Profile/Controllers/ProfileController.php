<?php

namespace App\Modules\Profile\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Master\Models\User;
use App\Modules\Master\Repository\UserRepository;
use App\Modules\Profile\Models\Follower;
use App\Modules\Profile\Repository\FollowerRepository;
use App\Modules\S3Storage\Lib\S3Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

        $user = UserRepository::getByUsername($username);
        if($user->isDirty()) {
            abort(404);
        }

        if($request->isMethod('POST')) {
            return $this->store($user);
        }

        return $this->show($user);
    }

    function show(User $user): View
    {
        $dynamicData = [
            'username' => $user->username,
            'user' => $user,
            'posts' => Cache::remember("user_posts_{$user->id}", now()->addMinutes(10), function() use ($user) {
                return $user->post()->orderByDesc('posts.id')->limit(100)->get();
            }),
            'followers' => FollowerRepository::getByFollowers($user->id),
            'following' => FollowerRepository::getByFollowing($user->id),
            'isFollower' => FollowerRepository::getFirst($user->id, false),
        ];

        return view('profile', $dynamicData);
    }

    function store(User $user): RedirectResponse
    {
        $username = $user->username;

        $follower = FollowerRepository::getFirst($user->id, auth()->user()->id);
        if($follower !== null) {
            return $this->unflower($user);
        }

        $isSave = FollowerRepository::save([
            'follower_id' => auth()->user()->id,
            'following_id' => $user->id,
        ]);

        if($isSave) {
            return back()->with('success', "Follower $username successfully");
        }

        return back()->withErrors("Something went wrong");
    }

    function unflower(User $user): RedirectResponse
    {
        $username = $user->username;

        $follower = FollowerRepository::getFirst($user->id, auth()->user()->id);
        if($follower->isDirty()) {
            return back()->with('success', "Unfollow $username successfully");
        }

        $isRemove = FollowerRepository::remove([
            'following_id' => auth()->user()->id,
            'follower_id' => $user->id,
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

        $user = UserRepository::getById(auth()->user()->id);

        $updateData = [];
        if(isset($data['picture'])) {
            $picture = $data['picture'];

            if(isset($user->picture)) {
                if(!S3Storage::deleteFile($user->picture)) {
                    return back()->withErrors("Update profile data failed");
                }
            }

            if(!S3Storage::putFile('/', $picture)) {
                return back()->withErrors("Update profile data failed");
            }

            $updateData['picture'] = S3Storage::getFile($picture->hashName());
        }

        $updateData['id'] = auth()->user()->id;
        $updateData['description'] = $data['description'];

        $updateData['socialnetworks']['patreon'] = $data['patreon'];
        $updateData['socialnetworks']['github'] = $data['github'];
        $updateData['socialnetworks']['discord'] = $data['discord'];
        $updateData['socialnetworks']['tiktok'] = $data['tiktok'];
        $updateData['socialnetworks']['twitter'] = $data['twitter'];

        if(!UserRepository::update($updateData)) {
            return back()->withErrors("Update profile data failed");
        }

        return back()->with('success', "Profile updated successfully");
    }

}
