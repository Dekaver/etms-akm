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
        Schema::create('history_daily_inspects', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("site_id")->constrained("sites");
            $table->foreignId("tire_id")->constrained("tires");
            $table->foreignId("unit_id")->constrained("units");
            $table->unsignedBigInteger('tire_damage_id')->nullable();
            $table->tinyInteger("position")->default(0);
            $table->integer("rtd")->default(0);
            $table->integer("pressure")->default(0);
            $table->integer("lifetime")->default(0);
            $table->date("date");
            $table->enum("velg", ["baik"]);
            $table->timestamps();
            $table->foreign('tire_damage_id')->references('id')->on('tire_damages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_daily_inspects');
    }
};
