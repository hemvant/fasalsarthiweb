<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserCrop;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CropController extends Controller
{
    /**
     * List authenticated user's crops.
     */
    public function index(Request $request): JsonResponse
    {
        $crops = $request->user()
            ->crops()
            ->orderBy('updated_at', 'desc')
            ->get()
            ->map(fn (UserCrop $c) => $this->cropResource($c));

        return response()->json(['crops' => $crops]);
    }

    /**
     * Store a new crop for the authenticated user.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'variety' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'stage' => 'nullable|string|max:100',
            'health' => 'nullable|string|in:excellent,good,fair,poor',
            'farm_name' => 'nullable|string|max:255',
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

        $crop = $request->user()->crops()->create(array_merge($validated, [
            'area' => $validated['area'] ?? 0,
            'health' => $validated['health'] ?? 'good',
        ]));

        return response()->json(['crop' => $this->cropResource($crop)], 201);
    }

    /**
     * Update a crop belonging to the authenticated user.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $crop = $request->user()->crops()->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'variety' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'stage' => 'nullable|string|max:100',
            'health' => 'nullable|string|in:excellent,good,fair,poor',
            'farm_name' => 'nullable|string|max:255',
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

        $crop->update($validated);

        return response()->json(['crop' => $this->cropResource($crop->fresh())]);
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
            'name' => $c->name,
            'variety' => $c->variety ?? '',
            'area' => (string) $c->area,
            'stage' => $c->stage ?? '',
            'health' => $c->health ?? 'good',
            'farm_name' => $c->farm_name,
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
