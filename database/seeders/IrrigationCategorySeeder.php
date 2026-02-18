<?php

namespace Database\Seeders;

use App\Models\IrrigationCategory;
use Illuminate\Database\Seeder;

class IrrigationCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Drip', 'slug' => 'drip', 'sort_order' => 1],
            ['name' => 'Sprinkler', 'slug' => 'sprinkler', 'sort_order' => 2],
            ['name' => 'Rainwater', 'slug' => 'rainwater', 'sort_order' => 3],
            ['name' => 'Micro Irrigation', 'slug' => 'micro-irrigation', 'sort_order' => 4],
        ];

        foreach ($categories as $cat) {
            IrrigationCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                ['name' => $cat['name'], 'sort_order' => $cat['sort_order'], 'is_active' => true]
            );
        }
    }
}
