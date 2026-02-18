<?php

namespace App\Http\Controllers\Expert;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();
        $profile = $user->expertProfile;

        $totalAnswers = $profile->total_answers ?? 0;
        $rating = $profile->rating ?? 0;
        $pendingQuestions = CommunityPost::where('status', 'active')->where('is_solved', false)->count();
        $trendingCrops = CommunityPost::where('status', 'active')
            ->whereNotNull('crop_id')
            ->selectRaw('crop_id, count(*) as total')
            ->groupBy('crop_id')
            ->orderByDesc('total')
            ->take(5)
            ->with('crop:id,title')
            ->get()
            ->pluck('crop.title', 'crop_id')
            ->filter();

        return view('expert.dashboard', [
            'profile' => $profile,
            'totalAnswers' => $totalAnswers,
            'rating' => $rating,
            'pendingQuestions' => $pendingQuestions,
            'trendingCrops' => $trendingCrops,
        ]);
    }
}
