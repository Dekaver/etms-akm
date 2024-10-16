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
        Schema::create('tire_movement_foremans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tire_movement_id')->constrained('tire_movements')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('teknisi_id')->constrained('teknisis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_movement_foremans');
    }
};
