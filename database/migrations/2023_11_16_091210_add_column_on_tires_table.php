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
        Schema::table('tires', function (Blueprint $table) {
            $table->boolean("is_repairing")->default(false)->after('is_repair');
            $table->boolean("is_retreading")->default(false)->after('is_retread');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->dropColumn('is_repairing');
            $table->dropColumn('is_retreading');
        });
    }
};
