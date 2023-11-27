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
        Schema::table('tire_sizes', function (Blueprint $table) {
            $table->dropColumn("target_lifetime");
            $table->integer("target_lifetime_km")->nullable();
            $table->integer("target_lifetime_hm")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tire_sizes', function (Blueprint $table) {
            $table->integer("target_lifetime")->nullable();
            $table->dropColumn("target_lifetime_km");
            $table->dropColumn("target_lifetime_hm");
        });
    }
};
