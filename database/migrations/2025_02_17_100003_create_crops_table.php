<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_category_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt', 500)->nullable();
            $table->string('featured_image')->nullable();
            $table->string('season')->nullable(); // Rabi, Kharif, etc.
            $table->string('duration')->nullable(); // e.g. "120-140 Days"
            $table->string('badge_text')->nullable(); // e.g. "Rabi Season"
            $table->string('stat_yield')->nullable(); // e.g. "25-30"
            $table->string('stat_yield_label')->nullable(); // e.g. "Quintal/Acre Yield"
            $table->string('stat_profit')->nullable();
            $table->string('stat_profit_label')->nullable();
            $table->string('stat_temperature')->nullable();
            $table->string('stat_temperature_label')->nullable();
            $table->string('stat_rainfall')->nullable();
            $table->string('stat_rainfall_label')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->string('og_image')->nullable();
            $table->longText('about')->nullable();
            $table->longText('suitable_regions')->nullable();
            $table->longText('soil_requirements')->nullable();
            $table->json('varieties')->nullable(); // [{"name","duration","yield","features"}]
            $table->longText('growing_guide')->nullable();
            $table->json('growth_stages')->nullable(); // [{"title","duration","description","icon"}]
            $table->longText('pest_management')->nullable();
            $table->longText('harvesting_guide')->nullable();
            $table->longText('profit_analysis')->nullable();
            $table->longText('government_support')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crops');
    }
};
