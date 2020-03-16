<?php

namespace App\Http\Controllers;

use App\Events\ReplyReceivedLike;
use Illuminate\Http\Request;
use App\Reply;
use Illuminate\Support\Facades\Redirect;
use App\User;

class FavoritesController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new favorite in the database.
     *
     * @param  Reply $reply
     * @return Redirect
     */
    public function store(Reply $reply)
    {
        $user = auth()->user();
        $reply->favorite($reply, $user);
        return back();
    }

    /**
     * Delete the favorite.
     *
     * @param Reply $reply
     */
    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
    }
}
