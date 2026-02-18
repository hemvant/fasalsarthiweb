<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Exchange Google OAuth authorization code for our token.
     * Mobile app uses expo-auth-session to get the code, then sends it here.
     */
    public function googleCode(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'redirect_uri' => 'required|string',
        ]);

        $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
            'code' => $request->code,
            'client_id' => config('services.google.client_id'),
            'client_secret' => config('services.google.client_secret'),
            'redirect_uri' => $request->redirect_uri,
            'grant_type' => 'authorization_code',
        ]);

        if (!$response->successful()) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired Google authorization code.'],
            ]);
        }

        $data = $response->json();
        $accessToken = $data['access_token'] ?? null;
        if (!$accessToken) {
            throw ValidationException::withMessages(['code' => ['No access token from Google.']]);
        }

        return $this->google(new Request(['access_token' => $accessToken]));
    }

    /**
     * Exchange Facebook OAuth authorization code for our token.
     */
    public function facebookCode(Request $request): JsonResponse
    {
        $request->validate([
            'code' => 'required|string',
            'redirect_uri' => 'required|string',
        ]);

        $redirectUri = $request->redirect_uri;
        $tokenUrl = 'https://graph.facebook.com/v18.0/oauth/access_token?' . http_build_query([
            'client_id' => config('services.facebook.client_id'),
            'client_secret' => config('services.facebook.client_secret'),
            'redirect_uri' => $redirectUri,
            'code' => $request->code,
        ]);

        $response = Http::get($tokenUrl);
        if (!$response->successful()) {
            throw ValidationException::withMessages([
                'code' => ['Invalid or expired Facebook authorization code.'],
            ]);
        }

        $data = $response->json();
        $accessToken = $data['access_token'] ?? null;
        if (!$accessToken) {
            throw ValidationException::withMessages(['code' => ['No access token from Facebook.']]);
        }

        return $this->facebook(new Request(['access_token' => $accessToken]));
    }

    /**
     * Login or register with Google access token.
     * Mobile app sends the OAuth2 access_token from Google sign-in.
     */
    public function google(Request $request): JsonResponse
    {
        $request->validate(['access_token' => 'required|string']);

        $response = Http::withToken($request->access_token)
            ->get('https://www.googleapis.com/oauth2/v2/userinfo');

        if (!$response->successful()) {
            throw ValidationException::withMessages([
                'access_token' => ['Invalid or expired Google token.'],
            ]);
        }

        $data = $response->json();
        $email = $data['email'] ?? null;
        $name = $data['name'] ?? 'Farmer';
        $providerId = (string) ($data['id'] ?? '');

        if (!$email) {
            throw ValidationException::withMessages([
                'access_token' => ['Google account must have an email.'],
            ]);
        }

        $user = User::firstOrCreate(
            [
                'provider' => 'google',
                'provider_id' => $providerId,
            ],
            [
                'name' => $name,
                'email' => $email,
                'password' => null,
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update(['name' => $name, 'email' => $email]);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userResource($user),
        ]);
    }

    /**
     * Login or register with Facebook access token.
     */
    public function facebook(Request $request): JsonResponse
    {
        $request->validate(['access_token' => 'required|string']);

        $response = Http::get('https://graph.facebook.com/me', [
            'fields' => 'id,name,email',
            'access_token' => $request->access_token,
        ]);

        if (!$response->successful()) {
            throw ValidationException::withMessages([
                'access_token' => ['Invalid or expired Facebook token.'],
            ]);
        }

        $data = $response->json();
        $email = $data['email'] ?? null;
        $name = $data['name'] ?? 'Farmer';
        $providerId = (string) ($data['id'] ?? '');

        if (!$email) {
            throw ValidationException::withMessages([
                'access_token' => ['Facebook account must have an email.'],
            ]);
        }

        $user = User::firstOrCreate(
            [
                'provider' => 'facebook',
                'provider_id' => $providerId,
            ],
            [
                'name' => $name,
                'email' => $email,
                'password' => null,
            ]
        );

        if (!$user->wasRecentlyCreated) {
            $user->update(['name' => $name, 'email' => $email]);
        }

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userResource($user),
        ]);
    }

    /**
     * Demo login: instant login as a demo farmer (for development / when OAuth not configured).
     */
    public function demo(Request $request): JsonResponse
    {
        $user = User::firstOrCreate(
            [
                'provider' => 'demo',
                'provider_id' => 'demo-1',
            ],
            [
                'name' => 'Demo Farmer',
                'email' => 'demo@farmer.app',
                'password' => null,
            ]
        );

        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $this->userResource($user),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }

    private function userResource(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
            'provider' => $user->provider,
        ];
    }
}
