<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\Channels\CreateChannelRequest;
use App\Http\Requests\Channels\UpdateChannelRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;

class ChannelsController extends Controller
{
    /**
     * Create a new ChannelsController instance.
     */
    public function __construct()
    {
        $this->middleware('admin')->except(['index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('channels.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateChannelRequest $request
     * @return RedirectResponse
     */
    public function store(CreateChannelRequest $request)
    {
        $channel = Channel::create($request->all());

        Cache::forget('channels');

        if (request()->wantsJson()) {
            return response($channel, 201);
        }

        return redirect('/channels')
            ->with('flash_success', trans('channel.flash_created'));
    }

    /**
     * Update an existing channel.
     *
     * @param Channel $channel
     * @param UpdateChannelRequest $request
     * @return mixed
     */
    public function update(Channel $channel, UpdateChannelRequest $request)
    {
        $channel->update($request->all());

        Cache::forget('channels');

        return response(['channel' => $channel], 201);
    }

    /**
     * Delete the given channel.
     *
     * @param  Channel $channel
     * @return RedirectResponse
     *
     * @throws
     */
    public function destroy(Channel $channel)
    {
        if ($channel->threads_count !== 0) {
            abort(403);
        }

        $channel->delete();

        Cache::forget('channels');

        return redirect('/channels')
            ->with('flash_success', trans('channel.flash_deleted'));
    }
}
