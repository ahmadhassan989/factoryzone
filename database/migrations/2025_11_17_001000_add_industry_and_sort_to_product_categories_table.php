<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->foreignId('industry_id')
                ->nullable()
                ->after('parent_id')
                ->constrained('industries')
                ->nullOnDelete();

            $table->integer('sort_order')
                ->default(0)
                ->after('industry_id');
        });
    }

    public function down(): void
    {
        Schema::table('product_categories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('industry_id');
            $table->dropColumn('sort_order');
        });
    }
};

