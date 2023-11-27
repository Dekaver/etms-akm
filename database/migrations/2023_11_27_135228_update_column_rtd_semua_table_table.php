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
            $table->float('rtd', 8, 2)->change();
        });
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->float('rtd', 8, 2)->change();
        });
        Schema::table('daily_inspects', function (Blueprint $table) {
            $table->float('rtd', 8, 2)->change();
        });
        Schema::table('history_daily_inspects', function (Blueprint $table) {
            $table->float('rtd', 8, 2)->change();
        });
        Schema::table('tire_sizes', function (Blueprint $table) {
            $table->float('otd', 8, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tires', function (Blueprint $table) {
            $table->tinyInteger('rtd')->change();
        });
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->tinyInteger('rtd')->change();
        });
        Schema::table('daily_inspects', function (Blueprint $table) {
            $table->tinyInteger('rtd')->change();
        });
        Schema::table('history_daily_inspects', function (Blueprint $table) {
            $table->tinyInteger('rtd')->change();
        });
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->tinyInteger('otd')->change();
        });
    }
};
