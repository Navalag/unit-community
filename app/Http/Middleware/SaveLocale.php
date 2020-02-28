<?php

namespace App\Http\Middleware;

use Closure;

class SaveLocale
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->locale !== app()->getLocale()) {
                $user->locale = app()->getLocale();
                $user->save();
            }
        }

        return $next($request);
    }
}
