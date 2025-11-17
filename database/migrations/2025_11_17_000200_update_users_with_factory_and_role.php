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
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('factory_id')
                ->nullable()
                ->after('id')
                ->constrained('factories')
                ->nullOnDelete();

            $table->string('role')
                ->default('factory_owner')
                ->after('email'); // factory_owner, factory_admin, factory_staff, super_admin
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('factory_id');
            $table->dropColumn('role');
        });
    }
};

