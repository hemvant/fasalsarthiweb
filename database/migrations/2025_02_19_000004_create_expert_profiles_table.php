<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expert_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('qualification')->nullable();
            $table->string('experience')->nullable(); // e.g. "10 years"
            $table->string('specialization')->nullable(); // crop, dairy, soil, etc.
            $table->string('certificate_path')->nullable();
            $table->string('status', 20)->default('pending'); // pending, approved, rejected, suspended
            $table->decimal('rating', 3, 2)->default(0);
            $table->unsignedInteger('total_answers')->default(0);
            $table->string('availability', 20)->default('offline'); // online, offline
            $table->boolean('verified')->default(false);
            $table->timestamp('suspended_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expert_profiles');
    }
};
