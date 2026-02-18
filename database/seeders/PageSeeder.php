<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        Page::updateOrCreate(
            ['slug' => 'terms'],
            [
                'title' => 'Terms & Conditions',
                'content' => '<div class="policy-section"><h2>1. Acceptance of Terms</h2><p>By accessing and using the FasalSarthi website and app, you accept and agree to be bound by these Terms and Conditions.</p><h2>2. Use of Service</h2><p>FasalSarthi provides AI-powered farming assistance. You agree to use the service only for lawful purposes.</p><h2>3. User Account</h2><p>You are responsible for maintaining the confidentiality of your account and password.</p><h2>4. Intellectual Property</h2><p>All content on FasalSarthi is owned by us and protected by copyright laws.</p><h2>5. Contact</h2><p>For questions, contact support@fasalsarthi.com.</p></div>',
                'meta_title' => 'Terms & Conditions',
                'meta_description' => 'Terms and conditions for using FasalSarthi services.',
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'privacy'],
            [
                'title' => 'Privacy Policy',
                'content' => '<div class="policy-section"><h2>1. Information We Collect</h2><p>We collect information you provide when you register or use our app.</p><h2>2. How We Use Your Information</h2><p>We use your information to provide recommendations and improve our services. We do not sell your data.</p><h2>3. Data Security</h2><p>We implement security measures to protect your information.</p><h2>4. Your Rights</h2><p>You may request access or deletion of your data. Contact support@fasalsarthi.com.</p><h2>5. Contact</h2><p>For privacy questions, contact support@fasalsarthi.com.</p></div>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'How we collect, use, and protect your information.',
            ]
        );
    }
}
