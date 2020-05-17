<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $fillable = ['name'];

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * A tag belongs to many threads.
     *
     * @return BelongsToMany
     */
    public function threads(): BelongsToMany
    {
        return $this->belongsToMany(Thread::class);
    }

    /**
     * Set the proper name attribute.
     *
     * @param string $name
     */
    public function setNameAttribute($name): void
    {
        $this->attributes['name'] = $name;
        $this->attributes['slug'] = Str::slug($name, '-');
    }
}
