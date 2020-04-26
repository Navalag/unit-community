<?php

namespace App;

use App\Events\ReplyReceivedBestMark;
use App\Services\Reputation;
use Illuminate\Database\Eloquent\Model;
use App\Filters\ThreadFilters;
use Illuminate\Database\Eloquent\Builder;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Stevebauman\Purify\Facades\Purify;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class Thread extends Model
{
    use RecordsActivity;
    use Searchable;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['creator', 'channel'];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['isSubscribedTo'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'locked' => 'boolean',
        'pinned' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($thread) {
            Reputation::gain($thread->creator, Reputation::THREAD_WAS_PUBLISHED);
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();

            Reputation::lose($thread->creator, Reputation::THREAD_WAS_PUBLISHED);
        });
    }

    /**
     * Get a string path for the thread.
     *
     * @return string
     */
    public function path(): string
    {
        return LaravelLocalization::localizeUrl("/threads/{$this->channel->slug}/{$this->slug}");
    }

    /**
     * A thread may have many replies.
     *
     * @return HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class)
                    ->withCount('favorites')
                    ->with('owner');
    }

    /**
     * A thread belongs to a creator.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * A thread is assigned a channel.
     *
     * @return BelongsTo
     */
    public function channel(): BelongsTo
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * A thread can have a best reply.
     *
     * @return HasOne
     */
    public function bestReply(): HasOne
    {
        return $this->hasOne(Reply::class, 'thread_id');
    }

    /**
     * Add a reply to the thread.
     *
     * @param  array $reply
     * @return Model
     */
    public function addReply($reply): Model
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder       $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, ThreadFilters $filters): Builder
    {
        return $filters->apply($query);
    }

    /**
     * Subscribe a user to the current thread.
     *
     * @param  int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null): void
    {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    /**
     * A thread can have many subscriptions.
     *
     * @return HasMany
     */
    public function subscriptions(): HasMany
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute(): bool
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    /**
     * Determine if the thread has been updated since the user last read it.
     *
     * @param  User $user
     * @return bool
     *
     * @throws
     */
    public function hasUpdatesFor($user): bool
    {
        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > Cache::get($key);
    }

    /**
     * Get the route key name.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Access the body attribute.
     *
     * @param  string $body
     * @return string
     */
    public function getBodyAttribute($body): string
    {
        return Purify::clean($body);
    }

    /**
     * Set the proper slug attribute.
     *
     * @param string $value
     */
    public function setSlugAttribute($value)
    {
        $slug = Str::slug(Str::limit($value, 50, ''), '-');
        $original = $slug;
        $count = 2;

        while (static::whereSlug($slug)->exists()) {
            $slug = "{$original}-" . $count++;
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Get sum of favorites for all thread's replies.
     */
    public function getRepliesFavoritesCountAttribute(): int
    {
        return $this->replies()->get()->sum('favorites_count');
    }

    /**
     * Create new Visits instance.
     *
     * @return Visits
     */
    public function visits()
    {
        return new Visits($this);
    }

    /**
     * Mark the given reply as the best answer.
     *
     * @param Reply $reply
     */
    public function markBestReply(Reply $reply): void
    {
        if ($this->hasBestReply()) {
            Reputation::lose($this->bestReply->owner, Reputation::BEST_REPLY_AWARDED);
        }

        $this->update(['best_reply_id' => $reply->id]);

        Reputation::gain($reply->owner, Reputation::BEST_REPLY_AWARDED);

        event(new ReplyReceivedBestMark($reply));
    }

    /**
     * Determine if the thread has a current best reply.
     *
     * @return bool
     */
    public function hasBestReply(): bool
    {
        return ! is_null($this->best_reply_id);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray(): array
    {
        return $this->toArray() + ['path' => $this->path()];
    }
}
