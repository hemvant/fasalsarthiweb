<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Crop;
use App\Models\UserCrop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CropController extends Controller
{
    /**
     * List crops from DB (catalog) – for farmer to choose when adding. Only active crops.
     */
    public function catalog(Request $request): JsonResponse
    {
        $crops = Crop::where('is_active', true)
            ->orderBy('title')
            ->get(['id', 'title', 'slug'])
            ->map(fn (Crop $c) => ['id' => $c->id, 'title' => $c->title, 'slug' => $c->slug]);

        return response()->json(['crops' => $crops]);
    }

    /**
     * List authenticated user's crops (farmer's added crops).
     */
    public function index(Request $request): JsonResponse
    {
        $crops = $request->user()
            ->crops()
            ->with('crop:id,title,slug')
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn (UserCrop $c) => $this->cropResource($c));

        return response()->json(['crops' => $crops]);
    }

    /**
     * Store a new crop for the authenticated user. crop_id must be an active catalog crop.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'crop_id' => 'required|integer|exists:crops,id',
            'name' => 'nullable|string|max:255',
            'variety' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'stage' => 'nullable|string|max:100',
            'health' => 'nullable|string|in:excellent,good,fair,poor',
            'notes' => 'nullable|string',
            'planted_date' => 'nullable|date',
            'expected_harvest' => 'nullable|date',
            'yield_estimate' => 'nullable|string|max:100',
            'last_irrigation' => 'nullable|string|max:100',
            'next_action' => 'nullable|string|max:255',
            'water_needs' => 'nullable|integer|min:0|max:100',
            'nutrient_level' => 'nullable|integer|min:0|max:100',
            'temperature_range' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
        ]);

        $catalogCrop = Crop::where('id', $validated['crop_id'])->where('is_active', true)->firstOrFail();
        $name = $validated['name'] ?? $catalogCrop->title;

        $userCrop = $request->user()->crops()->create([
            'crop_id' => $catalogCrop->id,
            'name' => $name,
            'variety' => $validated['variety'] ?? null,
            'area' => $validated['area'] ?? 0,
            'stage' => $validated['stage'] ?? null,
            'health' => $validated['health'] ?? 'good',
            'notes' => $validated['notes'] ?? null,
            'planted_date' => $validated['planted_date'] ?? null,
            'expected_harvest' => $validated['expected_harvest'] ?? null,
            'yield_estimate' => $validated['yield_estimate'] ?? null,
            'last_irrigation' => $validated['last_irrigation'] ?? null,
            'next_action' => $validated['next_action'] ?? null,
            'water_needs' => $validated['water_needs'] ?? null,
            'nutrient_level' => $validated['nutrient_level'] ?? null,
            'temperature_range' => $validated['temperature_range'] ?? null,
            'icon' => $validated['icon'] ?? null,
        ]);

        return response()->json(['crop' => $this->cropResource($userCrop->load('crop'))], 201);
    }

    /**
     * Update a crop belonging to the authenticated user.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $crop = $request->user()->crops()->findOrFail($id);

        $validated = $request->validate([
            'crop_id' => 'sometimes|nullable|integer|exists:crops,id',
            'name' => 'sometimes|string|max:255',
            'variety' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'stage' => 'nullable|string|max:100',
            'health' => 'nullable|string|in:excellent,good,fair,poor',
            'notes' => 'nullable|string',
            'planted_date' => 'nullable|date',
            'expected_harvest' => 'nullable|date',
            'yield_estimate' => 'nullable|string|max:100',
            'last_irrigation' => 'nullable|string|max:100',
            'next_action' => 'nullable|string|max:255',
            'water_needs' => 'nullable|integer|min:0|max:100',
            'nutrient_level' => 'nullable|integer|min:0|max:100',
            'temperature_range' => 'nullable|string|max:50',
            'icon' => 'nullable|string|max:50',
        ]);

        if (array_key_exists('crop_id', $validated) && $validated['crop_id']) {
            $catalogCrop = Crop::where('id', $validated['crop_id'])->where('is_active', true)->firstOrFail();
            $validated['name'] = $validated['name'] ?? $catalogCrop->title;
        }
        $crop->update($validated);

        return response()->json(['crop' => $this->cropResource($crop->fresh()->load('crop'))]);
    }

    /**
     * Delete a crop belonging to the authenticated user.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $crop = $request->user()->crops()->findOrFail($id);
        $crop->delete();
        return response()->json(['message' => 'Crop deleted']);
    }

    private function cropResource(UserCrop $c): array
    {
        return [
            'id' => (string) $c->id,
            'crop_id' => $c->crop_id ? (string) $c->crop_id : null,
            'catalog_title' => $c->relationLoaded('crop') && $c->crop ? $c->crop->title : null,
            'name' => $c->name,
            'variety' => $c->variety ?? '',
            'area' => (string) $c->area,
            'stage' => $c->stage ?? '',
            'health' => $c->health ?? 'good',
            'notes' => $c->notes ?? '',
            'planted_date' => $c->planted_date?->format('Y-m-d'),
            'expected_harvest' => $c->expected_harvest?->format('Y-m-d'),
            'yield_estimate' => $c->yield_estimate ?? '',
            'last_irrigation' => $c->last_irrigation ?? '',
            'next_action' => $c->next_action ?? '',
            'water_needs' => (int) $c->water_needs,
            'nutrient_level' => (int) $c->nutrient_level,
            'temperature_range' => $c->temperature_range ?? '',
            'icon' => $c->icon ?? '🌱',
        ];
    }
}
