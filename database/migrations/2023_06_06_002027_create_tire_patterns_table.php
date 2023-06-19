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
        Schema::create('tire_patterns', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("tire_manufacture_id")->constrained("tire_manufactures");
            $table->string("pattern");
            $table->string("type_pattern");
            $table->timestamps();
            $table->unique(["tire_manufacture_id", "pattern", "type_pattern", "company_id"], "tire_patterns_multi_unique");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_patterns');
    }
};
