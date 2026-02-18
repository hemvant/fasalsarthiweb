<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->morphs('reportable'); // community_post or community_answer
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('reason')->nullable();
            $table->text('details')->nullable();
            $table->string('status', 20)->default('pending'); // pending, resolved, dismissed
            $table->foreignId('resolved_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
