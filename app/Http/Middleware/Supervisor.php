<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class Supervisor
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
        if (Auth::user()->jabatan !== 'Supervisor' || 'Admin') {
            return redirect()->back()->with('error', 'Halaman Waiting Approval Hanya bisa diakses Role Supervisor up');
        }
        return $next($request);
    }
}
