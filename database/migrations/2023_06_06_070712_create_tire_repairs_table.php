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
        Schema::create('tire_repairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId("tire_id")->constrained("tires");
            $table->foreignId("tire_status_id")->constrained("tire_statuses");
            $table->unsignedBigInteger('tire_damage_id')->nullable();
            $table->foreign('tire_damage_id')->references('id')->on('tire_damages');
            $table->string("reason")->nullable();
            $table->string("analisa")->nullable();
            $table->string("alasan")->nullable();
            $table->string("man_power")->nullable();
            $table->string("pic")->nullable();
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->string("move");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_repairs');
    }
};
