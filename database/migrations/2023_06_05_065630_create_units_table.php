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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId("unit_model")->constrained("unit_models");
            $table->foreignId("unit_status")->constrained("unit_statuss");
            $table->foreignId("site")->constrained("sites");
            $table->string("unit_number");
            $table->string("head");
            $table->integer("km");
            $table->integer("hm");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
