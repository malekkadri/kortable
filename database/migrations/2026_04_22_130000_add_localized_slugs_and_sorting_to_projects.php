<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_categories', function (Blueprint $table) {
            $table->unsignedInteger('sort_order')->default(0)->index()->after('is_active');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->json('slug_translations')->nullable()->after('slug');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('slug_translations');
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->dropColumn('sort_order');
        });
    }
};
