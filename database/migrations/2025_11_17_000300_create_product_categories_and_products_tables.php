<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('factory_id')->constrained('factories')->cascadeOnDelete();
            $table->foreignId('product_category_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->json('attributes')->nullable(); // dimensions, material, etc.

            // Catalog / pricing metadata
            $table->tinyInteger('status')->default(0); // 0=draft,1=active,2=inactive
            $table->decimal('base_price', 15, 2)->nullable();
            $table->char('currency', 3)->nullable();
            $table->string('unit', 50)->nullable(); // e.g. kg, piece, box

            // Legacy/simple pricing + pack metadata
            $table->decimal('price', 15, 2)->nullable();
            $table->string('price_type')->default('on_request'); // fixed, on_request
            $table->unsignedInteger('pack_size')->nullable();
            $table->decimal('pack_price', 15, 2)->nullable();

            // Publish flags
            $table->boolean('is_published')->default(false);
            $table->boolean('is_published_storefront')->default(false);
            $table->boolean('is_published_marketplace')->default(false);
            $table->timestamps();

            $table->unique(['factory_id', 'slug']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('product_categories');
    }
};
