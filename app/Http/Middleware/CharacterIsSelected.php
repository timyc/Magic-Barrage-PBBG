<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CharacterIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // redirect to home if characterId is not in session
        if (!$request->session()->has('characterId')) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
