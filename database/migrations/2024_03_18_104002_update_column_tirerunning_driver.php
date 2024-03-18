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
        Schema::table('history_tire_movements', function (Blueprint $table) {
            $table->foreignId("driver_id")->nullable()->constrained("drivers")->after('lokasi_breakdown');
        });
        Schema::table('tire_runnings', function (Blueprint $table) {
            $table->foreignId("driver_id")->nullable()->constrained("drivers")->after('lokasi_breakdown');
        });
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->foreignId("driver_id")->nullable()->constrained("drivers")->after('lokasi_breakdown');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('history_tire_movements', function (Blueprint $table) {
            $table->dropColumn("driver_id");
        });

        Schema::table('tire_runnings', function (Blueprint $table) {
            $table->dropColumn("driver_id");
        });
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->dropColumn("driver_id");
        });
    }
};
