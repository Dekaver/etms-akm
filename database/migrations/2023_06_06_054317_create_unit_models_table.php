<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('unit_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("tire_size_id")->constrained("tire_sizes");
            $table->string('brand')->nullable();
            $table->string("model");
            $table->string("type");
            $table->tinyInteger("tire_qty");
            $table->tinyInteger("axle_2_tire");
            $table->tinyInteger("axle_4_tire");
            $table->tinyInteger("axle_8_tire");
            $table->string("informasi_berat_kosong")->nullable();
            $table->string("distribusi_beban")->nullable();
            $table->string("standar_load_capacity")->nullable();
            $table->boolean("has_head")->default(false);
            $table->boolean("has_tail")->default(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unit_models');
    }
};
