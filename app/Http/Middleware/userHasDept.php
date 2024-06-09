<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class userHasDept
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()->departemen_id == null) {
            return redirect('/dashboard')->with('message', 'Anda belum memiliki departemen, silakan hubungi admin untuk menambahkan departemen Anda');
        }
        return $next($request);
    }
}