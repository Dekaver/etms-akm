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
        Schema::create('history_tire_movement_manpowers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('history_tire_movement_id')->constrained('history_tire_movements')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('teknisi_id')->constrained('teknisis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tire_movement_manpowers');
    }
};
