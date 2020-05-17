<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Events\ThreadEdited;
use App\Tag;
use App\Thread;
use Illuminate\Http\Response;
use Exception;
use App\Filters\ThreadFilters;
use App\Trending;
use App\Rules\Recaptcha;

class ThreadsController extends Controller
{
    /**
     * Create a new ThreadsController instance.
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  Channel      $channel
     * @param ThreadFilters $filters
     * @param Trending $trending
     *
     * @return Response
     */
    public function index(Channel $channel, ThreadFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);

        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', [
            'threads' => $threads,
            'trending' => $trending->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Recaptcha $recaptcha
     * @return Response
     *
     * @throws Exception
     */
    public function store(Recaptcha $recaptcha)
    {
        request()->validate([
            'title' => 'required|spamfree|max:150',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id',
            'tags' => 'nullable|spamfree|string|max:50',
            'g-recaptcha-response' => ['required', $recaptcha]
        ]);

        /** @var Thread $thread */
        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
            'slug'       => request('title'),
        ]);

        $this->saveTags($thread, request('tags', ''));

        return redirect($thread->path())
            ->with('flash', 'Your thread has been published!');
    }

    /**
     * Display the specified resource.
     *
     * @param $channel
     * @param  Thread  $thread
     * @param Trending $trending
     *
     * @return Response
     */
    public function show($channel, Thread $thread, Trending $trending)
    {
        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        $trending->push($thread);

        $thread->visits()->record();

        return view('threads.show', compact('thread'));
    }

    /**
     * Update the given thread.
     *
     * @param string $channel
     * @param Thread $thread
     * @return Thread
     * @throws
     */
    public function update($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        request()->validate([
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'tags' => 'nullable|spamfree|string|max:50',
        ]);

        $thread->update([
            'title' => request('title'),
            'body' => request('body'),
        ]);

        $this->saveTags($thread, request('tags', ''));

        $thread = $thread->fresh();

        event(new ThreadEdited($thread));

        return $thread;
    }

    /**
     * Delete the given thread.
     *
     * @param  Thread  $thread
     * @param          $channel
     * @return Response
     *
     * @throws Exception
     */
    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->delete();

        if (request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/threads');
    }

    /**
     * Fetch all relevant threads.
     *
     * @param Channel       $channel
     * @param ThreadFilters $filters
     * @return mixed
     */
    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::orderBy('pinned', 'DESC')
            ->latest()
            ->filter($filters);

        if ($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }
        
        return $threads->simplePaginate(15);
    }


    /**
     * Save tags associated with thread.
     *
     * @param Thread $thread
     * @param string $tags
     */
    protected function saveTags(Thread $thread, string $tags): void
    {
        $tags = array_map(
            'trim', array_slice(
                explode(',', $tags), 0, 3
            )
        );

        $tagsId = [];

        foreach ($tags as $name) {
            if ($name) {
                $tagsId[] = Tag::firstOrCreate(['name' => $name])->id;
            }
        }

        $thread->tags()->sync($tagsId);
    }
}
