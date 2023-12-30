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
        Schema::create('daily_inspect_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId("daily_inspect_id")->constrained("daily_inspects");
            $table->foreignId("tire_id")->constrained("tires");
            $table->unsignedBigInteger('tire_damage_id')->nullable();
            $table->tinyInteger("position")->default(0);
            $table->boolean("is_selected");
            $table->integer("last_hm_unit")->default(0);
            $table->integer("last_km_unit")->default(0);
            $table->integer("lifetime_hm")->default(0);
            $table->integer("lifetime_km")->default(0);
            $table->integer("diff_hm")->default(0);
            $table->integer("diff_km")->default(0);
            $table->integer("rtd")->default(0);
            $table->integer("pressure")->default(0);
            $table->enum("tube", ["Good", "Bad"])->default("Good");
            $table->enum("flap", ["Good", "Bad"])->default("Good");
            $table->enum("rim", ["Good", "Bad"])->default("Good");
            $table->boolean("t_pentil")->default(false);
            $table->text("remark")->nullable();
            $table->timestamps();
            $table->unique(["tire_id", "position", "daily_inspect_id"], "daily_inspect_detail_multi_unique");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_inspect_details');
    }
};
