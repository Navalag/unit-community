<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Services\Reputation;
use Illuminate\Support\Facades\Redirect;

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
        $reply->favorite($reply, auth()->user());

        Reputation::award($reply->owner, Reputation::REPLY_FAVORITED);

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

        Reputation::reduce($reply->owner, Reputation::REPLY_FAVORITED);
    }
}
