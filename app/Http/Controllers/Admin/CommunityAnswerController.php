<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityAnswer;
use Illuminate\Http\RedirectResponse;

class CommunityAnswerController extends Controller
{
    public function destroy(CommunityAnswer $answer): RedirectResponse
    {
        $post = $answer->communityPost;
        $answer->delete();
        $post->expert_replied = $post->answers()->whereHas('user.expertProfile')->exists();
        $post->save();
        return back()->with('success', 'Answer deleted.');
    }

    public function pin(CommunityAnswer $answer): RedirectResponse
    {
        $answer->communityPost->answers()->update(['is_pinned' => false]);
        $answer->update(['is_pinned' => true]);
        return back()->with('success', 'Answer pinned.');
    }

    public function unpin(CommunityAnswer $answer): RedirectResponse
    {
        $answer->update(['is_pinned' => false]);
        return back()->with('success', 'Answer unpinned.');
    }

    public function markBest(CommunityAnswer $answer): RedirectResponse
    {
        $answer->communityPost->answers()->update(['is_best_answer' => false]);
        $answer->update(['is_best_answer' => true]);
        $answer->communityPost->update(['is_solved' => true]);
        return back()->with('success', 'Marked as best answer.');
    }
}
