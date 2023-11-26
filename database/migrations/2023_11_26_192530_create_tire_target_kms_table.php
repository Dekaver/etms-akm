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
        Schema::create('tire_target_km', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained("companies");
            $table->foreignId('site_id')->constrained("sites");
            $table->foreignId('tire_size_id')->constrained('tire_sizes');
            $table->float('rtd_target_km');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_target_km');
    }
};
