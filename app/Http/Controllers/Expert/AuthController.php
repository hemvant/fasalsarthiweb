<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\ExpertProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('expert.login');
    }

    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('expert.login')->with('error', 'Google login failed.');
        }

        $user = User::firstOrCreate(
            [
                'provider' => 'google',
                'provider_id' => $googleUser->getId(),
            ],
            [
                'name' => $googleUser->getName() ?? $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'password' => null,
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update([
                'name' => $user->name ?: $googleUser->getName(),
                'email' => $googleUser->getEmail(),
            ]);
        }

        Auth::guard('web')->login($user, true);

        $profile = $user->expertProfile;
        if (!$profile) {
            ExpertProfile::create([
                'user_id' => $user->id,
                'status' => ExpertProfile::STATUS_PENDING,
            ]);
            return redirect()->route('expert.register');
        }
        if ($profile->status === ExpertProfile::STATUS_APPROVED && !$profile->isSuspended()) {
            return redirect()->route('expert.dashboard');
        }
        if ($profile->status === ExpertProfile::STATUS_REJECTED) {
            return redirect()->route('expert.register')->with('error', 'Your expert application was rejected.');
        }
        if ($profile->status === ExpertProfile::STATUS_SUSPENDED) {
            Auth::logout();
            return redirect()->route('expert.login')->with('error', 'Your expert account is suspended.');
        }
        return redirect()->route('expert.register')->with('message', 'Your application is pending approval.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('expert.landing');
    }
}
