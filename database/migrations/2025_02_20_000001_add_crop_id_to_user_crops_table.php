<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_crops', function (Blueprint $table) {
            $table->foreignId('crop_id')->nullable()->after('user_id')->constrained('crops')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('user_crops', function (Blueprint $table) {
            $table->dropForeign(['crop_id']);
        });
    }
};
