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
        Schema::create('daily_inspect_foremans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_inspect_id')->constrained('daily_inspects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('teknisi_id')->constrained('teknisis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_inspect_foremans');
    }
};