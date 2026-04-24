<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->foreignId('linked_blog_category_id')
                ->nullable()
                ->after('linked_page_id')
                ->constrained('blog_categories')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropConstrainedForeignId('linked_blog_category_id');
        });
    }
};
