<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->isBanned()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Account is suspended or banned.'], 403);
            }
            auth()->logout();
            return redirect()->route('expert.login')->with('error', 'Your account is suspended or banned.');
        }
        return $next($request);
    }
}
