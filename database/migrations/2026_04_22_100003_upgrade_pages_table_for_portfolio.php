<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->json('slug_translations')->nullable()->after('slug');
            $table->json('content')->nullable()->after('excerpt');
            $table->string('featured_image')->nullable()->after('content');
            $table->boolean('is_active')->default(true)->after('featured_image');
            $table->string('template')->default('default')->after('is_active');
            $table->json('seo')->nullable()->after('template');
            $table->timestamp('published_at')->nullable()->after('seo');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            $table->dropColumn([
                'slug_translations',
                'content',
                'featured_image',
                'is_active',
                'template',
                'seo',
                'published_at',
            ]);
        });
    }
};
