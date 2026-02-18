<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('crop_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('problem_category_id')->constrained()->cascadeOnDelete();
            $table->text('body');
            $table->string('status', 20)->default('active'); // active, hidden, deleted
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('report_count')->default(0);
            $table->unsignedInteger('likes_count')->default(0);
            $table->unsignedInteger('comments_count')->default(0);
            $table->boolean('expert_replied')->default(false);
            $table->boolean('comments_locked')->default(false);
            $table->boolean('is_solved')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('community_posts');
    }
};
