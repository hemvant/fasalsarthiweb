<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('expert_articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('expert_article_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('body')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('status', 20)->default('draft'); // draft, published
            $table->boolean('featured')->default(false);
            $table->boolean('approved')->default(false); // admin approval
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expert_articles');
    }
};
