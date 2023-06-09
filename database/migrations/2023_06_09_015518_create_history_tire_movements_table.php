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
        Schema::create('history_tire_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("site_id")->constrained("sites");
            $table->string("unit");
            $table->string("tire");
            $table->string("position");
            $table->string("status");
            $table->string("km_install");
            $table->string("hm_install");
            $table->string("km_remove");
            $table->string("hm_remove");
            $table->string("pic");
            $table->string("pic_man_power");
            $table->string("des");
            $table->string("km_tire_install");
            $table->string("hm_tire_install");
            $table->string("km_tire_remove");
            $table->string("hm_tire_remove");
            $table->timestamp("start_date");
            $table->timestamp("end_date");

            $table->string('start_breakdown')->nullable();
            $table->string('status_breakdown')->nullable();
            $table->string('lokasi_breakdown')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_tire_movements');
    }
};
