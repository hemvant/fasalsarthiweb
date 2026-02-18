<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Crop Management', 'slug' => 'crop-management', 'sort_order' => 1],
            ['name' => 'Pest Control', 'slug' => 'pest-control', 'sort_order' => 2],
            ['name' => 'Water Management', 'slug' => 'water-management', 'sort_order' => 3],
            ['name' => 'Soil Health', 'slug' => 'soil-health', 'sort_order' => 4],
            ['name' => 'Market Insights', 'slug' => 'market-insights', 'sort_order' => 5],
            ['name' => 'Sustainable Farming', 'slug' => 'sustainable-farming', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            BlogCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'sort_order' => $cat['sort_order'], 'is_active' => true]
            );
        }
    }
}
