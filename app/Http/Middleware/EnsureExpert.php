<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureExpert
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('expert.login');
        }
        $profile = $request->user()->expertProfile;
        if (!$profile) {
            return redirect()->route('expert.register');
        }
        if ($profile->status === 'rejected') {
            return redirect()->route('expert.register')->with('error', 'Your expert application was rejected.');
        }
        if ($profile->status === 'suspended' || $profile->suspended_at) {
            return redirect()->route('expert.login')->with('error', 'Your expert account is suspended.');
        }
        if ($profile->status !== 'approved') {
            return redirect()->route('expert.register')->with('message', 'Your application is pending approval.');
        }
        return $next($request);
    }
}
