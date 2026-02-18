<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('scheme_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->string('featured_image')->nullable();
            $table->string('badge_text')->nullable();
            $table->string('ministry')->nullable();
            $table->string('deadline')->nullable();
            $table->string('stat1_value')->nullable();
            $table->string('stat1_label')->nullable();
            $table->string('stat2_value')->nullable();
            $table->string('stat2_label')->nullable();
            $table->string('stat3_value')->nullable();
            $table->string('stat3_label')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->longText('about')->nullable();
            $table->longText('benefits')->nullable();
            $table->longText('eligibility_criteria')->nullable();
            $table->longText('premium_rates')->nullable();
            $table->longText('application_process')->nullable();
            $table->longText('documents_required')->nullable();
            $table->longText('covered_crops')->nullable();
            $table->longText('claim_process')->nullable();
            $table->string('apply_cta_title')->nullable();
            $table->text('apply_cta_text')->nullable();
            $table->string('apply_cta_button_text')->nullable();
            $table->string('apply_cta_button_url')->nullable();
            $table->string('helpline_phone')->nullable();
            $table->string('helpline_email')->nullable();
            $table->longText('important_dates')->nullable();
            $table->json('benefit_tags')->nullable();
            $table->json('resources')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schemes');
    }
};
