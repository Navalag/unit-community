<?php

namespace App;

trait Favoritable
{

    public function isFavorited()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $atributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($atributes)->exists()) {
            return $this->favorites()->create($atributes);
        }
    }
}
