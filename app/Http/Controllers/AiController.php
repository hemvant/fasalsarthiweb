<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    private const CHAT_LIMIT = 3;
    private const IMAGE_LIMIT = 3;
    private const CHAT_SESSION_KEY = 'ai_chat_used';
    private const IMAGE_SESSION_KEY = 'ai_image_used';

    /**
     * Agriculture expert system instruction for Gemini.
     */
    private const SYSTEM_INSTRUCTION = 'You are an expert in agriculture, farming, crops, soil, weather, pests, and rural livelihood. '
        . 'Answer ONLY questions related to agriculture, farming, crops, livestock, soil, irrigation, fertilizers, pests, diseases, weather impact on crops, and similar topics. '
        . 'If the user asks about anything else (sports, politics, general knowledge, etc.), politely decline and say: "I am an agriculture expert. Please ask me only about farming, crops, or related topics." '
        . 'Keep answers helpful, concise, and practical for farmers.';

    public function chat(Request $request): JsonResponse
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $used = (int) session(self::CHAT_SESSION_KEY, 0);
        if ($used >= self::CHAT_LIMIT) {
            return response()->json([
                'success' => false,
                'limit_reached' => true,
                'message' => 'You have used your 3 free chats. Download our app for unlimited AI assistance.',
            ], 429);
        }

        $key = config('services.gemini.key');
        if (! $key) {
            return response()->json(['success' => false, 'message' => 'AI service is not configured.'], 503);
        }

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$key}";

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $request->message]],
                ],
            ],
            'systemInstruction' => [
                'parts' => [['text' => self::SYSTEM_INSTRUCTION]],
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
            ],
        ];

        try {
            $response = Http::timeout(30)->post($url, $payload);
            $data = $response->json();

            if (! $response->successful()) {
                Log::warning('Gemini API error', ['response' => $data]);
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to get a response. Please try again.',
                ], 502);
            }

            $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
            if ($text === '') {
                return response()->json(['success' => false, 'message' => 'No response from AI.']);
            }

            session([self::CHAT_SESSION_KEY => $used + 1]);
            $remaining = self::CHAT_LIMIT - $used - 1;

            return response()->json([
                'success' => true,
                'reply' => $text,
                'remaining' => $remaining,
            ]);
        } catch (\Throwable $e) {
            Log::error('Gemini chat error', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Something went wrong. Please try again.'], 500);
        }
    }

    public function identifyDisease(Request $request): JsonResponse
    {
        $request->validate(['image' => 'required|image|max:5120']); // 5MB

        $used = (int) session(self::IMAGE_SESSION_KEY, 0);
        if ($used >= self::IMAGE_LIMIT) {
            return response()->json([
                'success' => false,
                'limit_reached' => true,
                'message' => 'You have used your 3 free identifications. Download our app for more.',
            ], 429);
        }

        $apiKey = config('services.plantix.key');
        $imagePath = $request->file('image')->getRealPath();
        $imageData = base64_encode(file_get_contents($imagePath));
        $mime = $request->file('image')->getMimeType();

        if ($apiKey) {
            try {
                $response = Http::timeout(30)
                    ->withHeaders(['Authorization' => 'Bearer ' . $apiKey])
                    ->attach('image', file_get_contents($imagePath), 'image.jpg')
                    ->post(config('services.plantix.url', 'https://api.plantix.net/v1/analyze'));

                if ($response->successful()) {
                    $data = $response->json();
                    session([self::IMAGE_SESSION_KEY => $used + 1]);
                    $remaining = self::IMAGE_LIMIT - $used - 1;
                    return response()->json([
                        'success' => true,
                        'result' => $data,
                        'remaining' => $remaining,
                        'summary' => $this->summarizePlantixResponse($data),
                    ]);
                }
            } catch (\Throwable $e) {
                Log::warning('Plantix API error', ['error' => $e->getMessage()]);
            }
        }

        // Demo response when Plantix not configured or API fails
        session([self::IMAGE_SESSION_KEY => $used + 1]);
        $remaining = self::IMAGE_LIMIT - $used - 1;
        return response()->json([
            'success' => true,
            'remaining' => $remaining,
            'summary' => 'Upload a clear photo of the affected leaf or plant for best results. Our AI will identify possible diseases and suggest treatments. (Demo: Add PLANTIX_API_KEY in .env for live Plantix API.)',
            'demo' => true,
        ]);
    }

    private function summarizePlantixResponse(array $data): string
    {
        $lines = [];
        if (! empty($data['diagnosis'])) {
            $lines[] = 'Diagnosis: ' . (is_string($data['diagnosis']) ? $data['diagnosis'] : json_encode($data['diagnosis']));
        }
        if (! empty($data['recommendations'])) {
            $lines[] = 'Recommendations: ' . (is_string($data['recommendations']) ? $data['recommendations'] : implode('; ', (array) $data['recommendations']));
        }
        return $lines ? implode("\n", $lines) : 'Analysis complete. Check details above.';
    }

    public function limits(Request $request): JsonResponse
    {
        return response()->json([
            'chat_used' => (int) session(self::CHAT_SESSION_KEY, 0),
            'chat_limit' => self::CHAT_LIMIT,
            'image_used' => (int) session(self::IMAGE_SESSION_KEY, 0),
            'image_limit' => self::IMAGE_LIMIT,
        ]);
    }
}