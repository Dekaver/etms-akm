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
        Schema::create('tire_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("tire_pattern_id")->constrained("tire_patterns");
            $table->string("size");
            $table->integer("otd");
            $table->integer("recomended_pressure");
            $table->integer("target_lifetime_hm");
            $table->integer("target_lifetime_km");
            $table->integer("price")->default(0);
            $table->timestamps();
            $table->unique(["company_id", "size", "tire_pattern_id"]);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_sizes');
    }
};
