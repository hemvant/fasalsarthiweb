<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('theme_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('Default'); // optional: theme name for multi-theme later
            $table->string('primary_color', 20)->default('#059669');
            $table->string('secondary_color', 20)->default('#047857');
            $table->string('accent_color', 20)->default('#10B981');
            $table->string('text_dark_color', 20)->default('#1a1a1a');
            $table->string('text_light_color', 20)->default('#666666');
            $table->string('background_color', 20)->default('#ffffff');
            $table->string('success_color', 20)->default('#10B981');
            $table->string('warning_color', 20)->default('#F59E0B');
            $table->string('error_color', 20)->default('#EF4444');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_settings');
    }
};
