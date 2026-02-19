<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'provider' => $user->provider,
                'settings' => $user->settings ?? [],
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'mobile' => 'sometimes|nullable|string|max:20',
            'settings' => 'sometimes|nullable|array',
        ]);

        $request->user()->update($validated);

        $user = $request->user()->fresh();
        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'mobile' => $user->mobile,
                'provider' => $user->provider,
                'settings' => $user->settings ?? [],
            ],
        ]);
    }
}
