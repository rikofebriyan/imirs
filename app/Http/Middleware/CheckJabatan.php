<?php

namespace App\Http\Middleware;

use Closure;

class CheckJabatan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$jabatans)
{
    if (! $request->user()->hasAnyJabatan($jabatans)) {
        dd($request);
        return redirect()->route('unauthorized');
    }

    return $next($request);
}
}
