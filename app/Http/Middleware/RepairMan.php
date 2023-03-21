<?php

namespace App\Http\Middleware;

use Closure;

class RepairMan
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
        if (Auth::user()->jabatan !== 'RepairMan' ) {
            return redirect('home');
        }
        return $next($request);
    }
}
