<?php

namespace App\Http\Controllers;

use App\Models\Planguage;
use App\Models\User;
use GuzzleHttp\Client;

class ProfileController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts;
        $planguages = Planguage::get();

        $repositories = [];

        if (auth()->user()->provider_token) {
            $client = new Client();
            $res = $client->get(auth()->user()->repos_url);
            $repositories = json_decode($res->getBody());
        }

        return view('profile.index', compact('posts', 'planguages', 'repositories'));
    }

    public function view($userId)
    {
        if (auth()->check()) {
            if ($userId == auth()->user()->id) {
                return redirect('profile');
            }
        }

        $user = User::findOrFail($userId);

        $repositories = [];

        if ($user->provider_token) {
            $client = new Client();
            $res = $client->get(auth()->user()->repos_url);
            $repositories = json_decode($res->getBody());
        }

        return view('profile.view', compact('user', 'repositories'));
    }

    public function update_avatar()
    {
        request()->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        $user->custom_avatar = true;

        $avatarName = $user->id . '_avatar' . time() . '.' . request()->avatar->getClientOriginalExtension();

        request()->avatar->storeAs('avatars', $avatarName);

        $user->avatar = $avatarName;
        $user->save();

        return back()->with('success', 'You have successfully upload image.');
    }

    public function update()
    {
        auth()->user()->name = request('name');
        auth()->user()->bio = request('bio');
        auth()->user()->save();

        return back();
    }

    public function planguages()
    {
        $languages = request('planguages');

        auth()->user()->planguages()->sync($languages, true);

        return back();
    }
}
