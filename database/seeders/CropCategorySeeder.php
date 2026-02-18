<?php

namespace Database\Seeders;

use App\Models\CropCategory;
use Illuminate\Database\Seeder;

class CropCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Cereals', 'slug' => 'cereals', 'sort_order' => 1],
            ['name' => 'Pulses', 'slug' => 'pulses', 'sort_order' => 2],
            ['name' => 'Spices', 'slug' => 'spices', 'sort_order' => 3],
            ['name' => 'Vegetables', 'slug' => 'vegetables', 'sort_order' => 4],
            ['name' => 'Fruits', 'slug' => 'fruits', 'sort_order' => 5],
            ['name' => 'Cash Crops', 'slug' => 'cash-crops', 'sort_order' => 6],
        ];
        foreach ($categories as $c) {
            CropCategory::firstOrCreate(['slug' => $c['slug']], array_merge($c, ['is_active' => true]));
        }
    }
}
