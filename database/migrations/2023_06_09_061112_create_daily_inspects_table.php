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
        Schema::create('daily_inspects', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("site_id")->constrained("sites");
            $table->foreignId("tire_id")->constrained("tires");
            $table->foreignId("unit_id")->constrained("units");
            $table->unsignedBigInteger('tire_damage_id')->nullable();
            $table->tinyInteger("position")->default(0);
            $table->string("location")->nullable();
            $table->string("shift")->nullable();
            $table->string("pic")->nullable();
            $table->string("driver")->nullable();
            $table->integer("rtd")->default(0);
            $table->integer("pressure")->default(0);
            $table->integer("lifetime_hm")->default(0);
            $table->integer("lifetime_km")->default(0);
            $table->date("date");
            $table->enum("tube", ["Good", "Bad"])->default("Good");
            $table->enum("flap", ["Good", "Bad"])->default("Good");
            $table->enum("rim", ["Good", "Bad"])->default("Good");
            $table->boolean("t_pentil")->default(false);
            $table->text("remark")->nullable();
            $table->timestamps();
            $table->foreign('tire_damage_id')->references('id')->on('tire_damages');
            $table->unique(["company_id", "site_id", "position", "date", "unit_id", "tire_id"], "daily_inspect_multi_unique");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_inspects');
    }
};
