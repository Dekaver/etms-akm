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
        if (!Schema::hasTable('breakdown_unit_pics')) {
            Schema::create('breakdown_unit_pics', function (Blueprint $table) {
                $table->id();
                $table->foreignId('breakdown_unit_id')->constrained('breakdown_units')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreignId('teknisi_id')->constrained('teknisis');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_unit_pics');
    }
};
