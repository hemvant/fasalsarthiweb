<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        $features = [
            ['title' => 'AI Crop Recommendations', 'slug' => 'ai-crop-recommendations', 'excerpt' => 'Get personalized farming advice based on your location, soil type, and weather conditions.', 'icon' => 'fa-leaf', 'icon_color' => 'green', 'sort_order' => 1],
            ['title' => 'Weather Forecasts', 'slug' => 'weather-forecasts', 'excerpt' => 'Access weather predictions and alerts to help you plan your farming activities.', 'icon' => 'fa-cloud-sun', 'icon_color' => 'blue', 'sort_order' => 2],
            ['title' => 'Disease Prevention', 'slug' => 'disease-prevention', 'excerpt' => 'Early detection and prevention tips for crop diseases through image recognition.', 'icon' => 'fa-shield-alt', 'icon_color' => 'orange', 'sort_order' => 3],
            ['title' => 'Market Prices', 'slug' => 'market-prices', 'excerpt' => 'Real-time market prices and trends to help you make informed selling decisions.', 'icon' => 'fa-chart-line', 'icon_color' => 'green', 'sort_order' => 4],
            ['title' => 'Farmer Community', 'slug' => 'farmer-community', 'excerpt' => 'Connect with fellow farmers, share experiences, and learn from each other.', 'icon' => 'fa-users', 'icon_color' => 'purple', 'sort_order' => 5],
            ['title' => 'Sustainable Farming', 'slug' => 'sustainable-farming', 'excerpt' => 'Eco-friendly farming practices and organic farming tips for better yields.', 'icon' => 'fa-recycle', 'icon_color' => 'teal', 'sort_order' => 6],
        ];

        foreach ($features as $i => $data) {
            Feature::updateOrCreate(
                ['slug' => $data['slug']],
                array_merge($data, ['is_active' => true])
            );
        }
    }
}
