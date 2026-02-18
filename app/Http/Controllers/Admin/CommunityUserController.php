<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommunityUserController extends Controller
{
    public function index(Request $request): View
    {
        $users = User::with('expertProfile')
            ->when($request->filled('banned'), fn ($q) => $q->where('is_banned', true))
            ->latest()
            ->paginate(20);
        return view('admin.community.users.index', compact('users'));
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        $request->validate(['suspended_until' => 'nullable|date']);
        $user->update(['suspended_until' => $request->suspended_until ?: null]);
        return back()->with('success', 'User suspended.');
    }

    public function unsuspend(User $user): RedirectResponse
    {
        $user->update(['suspended_until' => null]);
        return back()->with('success', 'User unsuspended.');
    }

    public function ban(User $user): RedirectResponse
    {
        $user->update(['is_banned' => true]);
        return back()->with('success', 'User banned.');
    }

    public function unban(User $user): RedirectResponse
    {
        $user->update(['is_banned' => false]);
        return back()->with('success', 'User unbanned.');
    }
}
