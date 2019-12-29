<?php

namespace App\Http\Middleware;

use Closure;

class VerifiedFromAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_verified == false) {
            return redirect('/');
        }
        return $next($request);
    }
}
