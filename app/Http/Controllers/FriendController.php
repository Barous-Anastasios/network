<?php

namespace App\Http\Controllers;

use App\Models\User;

class FriendController extends Controller
{
    public function getUsers($users)
    {
        $ids = [];
        foreach ($users as $request) {
            $ids[] = $request->sender_id;
        }

        return User::whereIn('id', $ids)->get();
    }

    public function index()
    {
        // $recommended = User::where([
        //         ['country', '=', auth()->user()->country],
        //         ['programming_language', '=', auth()->user()->programming_language]
        //     ])->get();
        $recommended = [];

        $requests = $this->getUsers(auth()->user()->getFriendRequests());
        $friends = $this->getUsers(auth()->user()->getAcceptedFriendships());

        return view('friends.index', compact('recommended', 'requests', 'friends'));
    }

    public function connect()
    {
        auth()->user()->befriend(User::find(request()->id));

        return back()->with('success', 'Friend Request sent');
    }

    public function disconnect()
    {
        auth()->user()->unfriend(User::find(request()->id));

        return back()->with('success', 'Friend removed');
    }

    public function accept()
    {
        $user = User::find(request()->id);

        auth()->user()->acceptFriendRequest($user);

        return back()->with('success', 'Friend Accepted');
    }

    public function friends()
    {
        $friends = auth()->user()->getFriends();

        return view('profile.friends', compact('friends'));
    }
}
