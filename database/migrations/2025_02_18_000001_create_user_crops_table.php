<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_crops', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('variety')->nullable();
            $table->decimal('area', 10, 2)->default(0); // acres
            $table->string('stage')->nullable(); // Planted, Growing, Flowering, etc.
            $table->string('health')->default('good'); // excellent, good, fair, poor
            $table->string('farm_name')->nullable();
            $table->text('notes')->nullable();
            $table->date('planted_date')->nullable();
            $table->date('expected_harvest')->nullable();
            $table->string('yield_estimate')->nullable();
            $table->string('last_irrigation')->nullable();
            $table->string('next_action')->nullable();
            $table->unsignedTinyInteger('water_needs')->nullable();
            $table->unsignedTinyInteger('nutrient_level')->nullable();
            $table->string('temperature_range')->nullable();
            $table->string('icon')->nullable(); // emoji or icon name
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_crops');
    }
};
