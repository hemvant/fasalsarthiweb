<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\ExpertProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showForm(Request $request): View|RedirectResponse
    {
        if (!$request->user()) {
            return redirect()->route('expert.login');
        }
        $profile = $request->user()->expertProfile;
        if (!$profile) {
            return redirect()->route('expert.login');
        }
        if ($profile->status === ExpertProfile::STATUS_APPROVED) {
            return redirect()->route('expert.dashboard');
        }
        return view('expert.register', ['profile' => $profile]);
    }

    public function submit(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'experience' => 'required|string|max:100',
            'specialization' => 'required|string|max:255',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $user = $request->user();
        $user->update(['name' => $request->name]);

        $profile = $user->expertProfile;
        if (!$profile) {
            $profile = ExpertProfile::create(['user_id' => $user->id, 'status' => ExpertProfile::STATUS_PENDING]);
        }

        $data = [
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'specialization' => $request->specialization,
        ];
        if ($request->hasFile('certificate')) {
            if ($profile->certificate_path) {
                Storage::disk('public')->delete($profile->certificate_path);
            }
            $data['certificate_path'] = $request->file('certificate')->store('expert/certificates', 'public');
        }
        $profile->update($data);

        return redirect()->route('expert.register')->with('success', 'Application submitted. You will be notified once approved.');
    }
}
