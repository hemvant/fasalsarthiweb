<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@fasalsarthi.com'],
            [
                'name' => 'Admin',
                'password' => 'password', // Change this after first login in production
            ]
        );
    }
}
