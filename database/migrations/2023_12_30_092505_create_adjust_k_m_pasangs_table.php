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
        Schema::create('adjust_km_pasangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained('units');
            $table->foreignId('tire_id')->constrained('tires');
            $table->date('tanggal');
            $table->tinyInteger('position');
            $table->integer('km_unit');
            $table->integer('updated_km_unit');
            $table->integer('hm_unit');
            $table->integer('updated_hm_unit');
            $table->integer('km');
            $table->integer('updated_km');
            $table->integer('hm');
            $table->integer('updated_hm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjust_k_m_pasangs');
    }
};
