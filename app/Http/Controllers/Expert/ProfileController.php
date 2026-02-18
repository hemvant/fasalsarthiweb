<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $user = $request->user();
        $profile = $user->expertProfile;
        return view('expert.profile.edit', compact('user', 'profile'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'experience' => 'required|string|max:100',
            'specialization' => 'required|string|max:255',
            'availability' => 'boolean',
        ]);
        $request->user()->update(['name' => $request->name]);
        $request->user()->expertProfile->update([
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
            'availability' => $request->boolean('availability'),
        ]);
        return back()->with('success', 'Profile updated.');
    }
}
