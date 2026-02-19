<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserWeather;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    private const OPEN_METEO_URL = 'https://api.open-meteo.com/v1/forecast';
    private const REFRESH_INTERVAL_HOURS = 4;

    /**
     * Get saved weather for the authenticated user.
     * Returns cached data if fetched within last 4 hours.
     */
    public function show(Request $request): JsonResponse
    {
        $weather = $request->user()->weather;
        if (!$weather) {
            return response()->json([
                'weather' => null,
                'message' => 'No weather data. Send your location to refresh.',
            ]);
        }
        $shouldRefresh = $weather->fetched_at->diffInHours(now()) >= self::REFRESH_INTERVAL_HOURS;
        return response()->json([
            'weather' => $this->formatWeatherResponse($weather),
            'fetched_at' => $weather->fetched_at->toIso8601String(),
            'should_refresh' => $shouldRefresh,
        ]);
    }

    /**
     * Fetch fresh weather from Open-Meteo for given lat/lng, save for user, return data.
     */
    public function refresh(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'location_name' => 'nullable|string|max:255',
        ]);

        $lat = (float) $validated['latitude'];
        $lng = (float) $validated['longitude'];
        $locationName = $validated['location_name'] ?? null;

        $response = Http::timeout(10)->get(self::OPEN_METEO_URL, [
            'latitude' => $lat,
            'longitude' => $lng,
            'current' => 'temperature_2m,relative_humidity_2m,weather_code,wind_speed_10m,precipitation',
            'hourly' => 'temperature_2m,weather_code',
            'daily' => 'weather_code,temperature_2m_max,temperature_2m_min',
            'timezone' => 'Asia/Kolkata',
        ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Failed to fetch weather from provider.',
            ], 502);
        }

        $data = $response->json();
        $user = $request->user();

        $weather = $user->weather()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'latitude' => $lat,
                'longitude' => $lng,
                'location_name' => $locationName,
                'timezone' => $data['timezone'] ?? 'Asia/Kolkata',
                'data' => $data,
                'fetched_at' => now(),
            ]
        );

        return response()->json([
            'weather' => $this->formatWeatherResponse($weather),
            'fetched_at' => $weather->fetched_at->toIso8601String(),
        ]);
    }

    private function formatWeatherResponse(UserWeather $w): array
    {
        $d = $w->data;
        $current = $d['current'] ?? [];
        $hourly = $d['hourly'] ?? [];
        $daily = $d['daily'] ?? [];

        $hourlyTimes = $hourly['time'] ?? [];
        $hourlyTemp = $hourly['temperature_2m'] ?? [];
        $hourlyCode = $hourly['weather_code'] ?? [];
        $hourlySlice = [];
        $step = max(1, (int) floor(count($hourlyTimes) / 6));
        for ($i = 0; $i < count($hourlyTimes) && count($hourlySlice) < 6; $i += $step) {
            $hourlySlice[] = [
                'time' => $hourlyTimes[$i] ?? '',
                'temp' => (float) ($hourlyTemp[$i] ?? 0),
                'weather_code' => (int) ($hourlyCode[$i] ?? 0),
            ];
        }

        $dailyTimes = $daily['time'] ?? [];
        $dailyMax = $daily['temperature_2m_max'] ?? [];
        $dailyMin = $daily['temperature_2m_min'] ?? [];
        $dailyCode = $daily['weather_code'] ?? [];
        $dailySlice = [];
        for ($i = 0; $i < min(7, count($dailyTimes)); $i++) {
            $dailySlice[] = [
                'date' => $dailyTimes[$i] ?? '',
                'max' => (float) ($dailyMax[$i] ?? 0),
                'min' => (float) ($dailyMin[$i] ?? 0),
                'weather_code' => (int) ($dailyCode[$i] ?? 0),
            ];
        }

        return [
            'location_name' => $w->location_name,
            'latitude' => $w->latitude,
            'longitude' => $w->longitude,
            'timezone' => $w->timezone,
            'current' => [
                'temperature' => (float) ($current['temperature_2m'] ?? 0),
                'humidity' => (int) ($current['relative_humidity_2m'] ?? 0),
                'weather_code' => (int) ($current['weather_code'] ?? 0),
                'wind_speed_kmh' => (float) ($current['wind_speed_10m'] ?? 0),
                'precipitation_mm' => (float) ($current['precipitation'] ?? 0),
            ],
            'hourly' => $hourlySlice,
            'daily' => $dailySlice,
        ];
    }
}
