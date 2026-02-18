<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\CommunityAnswer;
use App\Models\ExpertProfile;
use App\Models\Report;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with community overview.
     */
    public function index(): View
    {
        $totalFarmers = User::count();
        $totalExperts = ExpertProfile::where('status', ExpertProfile::STATUS_APPROVED)->count();
        $pendingExperts = ExpertProfile::where('status', ExpertProfile::STATUS_PENDING)->count();
        $totalPosts = CommunityPost::count();
        $totalAnswers = CommunityAnswer::count();
        $reportedPosts = Report::where('reportable_type', CommunityPost::class)->where('status', 'pending')->count();

        return view('admin.dashboard', compact(
            'totalFarmers', 'totalExperts', 'pendingExperts',
            'totalPosts', 'totalAnswers', 'reportedPosts'
        ));
    }
}
