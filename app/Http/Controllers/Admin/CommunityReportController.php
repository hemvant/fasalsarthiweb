<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommunityReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with(['user', 'reportable'])->where('status', 'pending');
        if ($request->filled('type')) {
            $query->where('reportable_type', $request->type);
        }
        $reports = $query->latest()->paginate(20);
        return view('admin.community.reports.index', compact('reports'));
    }

    public function resolve(Report $report): RedirectResponse
    {
        $report->update([
            'status' => 'resolved',
            'resolved_by' => Auth::guard('admin')->id(),
            'resolved_at' => now(),
        ]);
        return back()->with('success', 'Report marked resolved.');
    }

    public function dismiss(Report $report): RedirectResponse
    {
        $report->update([
            'status' => 'dismissed',
            'resolved_by' => Auth::guard('admin')->id(),
            'resolved_at' => now(),
        ]);
        return back()->with('success', 'Report dismissed.');
    }
}
