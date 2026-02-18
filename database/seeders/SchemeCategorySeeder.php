<?php

namespace Database\Seeders;

use App\Models\SchemeCategory;
use Illuminate\Database\Seeder;

class SchemeCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Crop Insurance', 'slug' => 'crop-insurance', 'sort_order' => 1],
            ['name' => 'Income Support', 'slug' => 'income-support', 'sort_order' => 2],
            ['name' => 'Irrigation', 'slug' => 'irrigation', 'sort_order' => 3],
            ['name' => 'Subsidy', 'slug' => 'subsidy', 'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            SchemeCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'sort_order' => $cat['sort_order'], 'is_active' => true]
            );
        }
    }
}
