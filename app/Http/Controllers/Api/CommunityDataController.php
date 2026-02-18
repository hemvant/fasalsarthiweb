<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\ProblemCategory;
use Illuminate\Http\JsonResponse;

class CommunityDataController extends Controller
{
    /** Crops list for post dropdown (from main crops table). */
    public function crops(): JsonResponse
    {
        $crops = Crop::where('is_active', true)->orderBy('title')->get(['id', 'title']);
        return response()->json(['crops' => $crops]);
    }

    /** Problem categories for post dropdown. */
    public function problemCategories(): JsonResponse
    {
        $categories = ProblemCategory::where('is_active', true)->orderBy('sort_order')->get(['id', 'name', 'slug']);
        return response()->json(['problem_categories' => $categories]);
    }
}
