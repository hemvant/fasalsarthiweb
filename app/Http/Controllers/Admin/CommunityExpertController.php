<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ExpertProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunityExpertController extends Controller
{
    public function index(Request $request): View
    {
        $query = ExpertProfile::with('user');
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $experts = $query->latest()->paginate(20);
        return view('admin.community.experts.index', compact('experts'));
    }

    public function show(ExpertProfile $expert_profile): View
    {
        $expert_profile->load('user');
        return view('admin.community.experts.show', ['expert' => $expert_profile]);
    }

    public function approve(ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update(['status' => ExpertProfile::STATUS_APPROVED, 'suspended_at' => null]);
        return back()->with('success', 'Expert approved.');
    }

    public function reject(Request $request, ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update([
            'status' => ExpertProfile::STATUS_REJECTED,
            'admin_notes' => $request->input('admin_notes'),
        ]);
        return back()->with('success', 'Expert application rejected.');
    }

    public function suspend(Request $request, ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update([
            'status' => ExpertProfile::STATUS_SUSPENDED,
            'suspended_at' => now(),
            'admin_notes' => $request->input('admin_notes', $expert_profile->admin_notes),
        ]);
        return back()->with('success', 'Expert suspended.');
    }

    public function unsuspend(ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update(['status' => ExpertProfile::STATUS_APPROVED, 'suspended_at' => null]);
        return back()->with('success', 'Expert unsuspended.');
    }

    public function toggleVerification(ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update(['verified' => !$expert_profile->verified]);
        return back()->with('success', $expert_profile->verified ? 'Expert verified.' : 'Verification removed.');
    }

    public function updateNotes(Request $request, ExpertProfile $expert_profile): RedirectResponse
    {
        $expert_profile->update(['admin_notes' => $request->input('admin_notes')]);
        return back()->with('success', 'Notes updated.');
    }
}
