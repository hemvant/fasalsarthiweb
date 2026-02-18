<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Seeder;

class ProblemCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Disease', 'slug' => 'disease', 'sort_order' => 1],
            ['name' => 'Market Price', 'slug' => 'market-price', 'sort_order' => 2],
            ['name' => 'Irrigation', 'slug' => 'irrigation', 'sort_order' => 3],
            ['name' => 'Fertilizer', 'slug' => 'fertilizer', 'sort_order' => 4],
            ['name' => 'Government Scheme', 'slug' => 'government-scheme', 'sort_order' => 5],
        ];
        foreach ($categories as $cat) {
            ProblemCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}
