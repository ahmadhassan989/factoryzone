<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('factories', function (Blueprint $table) {
            $table->foreignId('industry_id')
                ->nullable()
                ->after('zone_id')
                ->constrained('industries')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('factories', function (Blueprint $table) {
            $table->dropConstrainedForeignId('industry_id');
        });
    }
};

