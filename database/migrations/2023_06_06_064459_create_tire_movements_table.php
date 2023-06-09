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
        Schema::create('tire_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("tire_running_id")->constrained("tire_runnings");
            $table->integer('hm')->default(0);
            $table->integer('km')->default(0);
            $table->integer('hm_actual')->default(0);
            $table->integer('km_actual')->default(0);
            $table->integer('unit_lifetime_hm')->default(0);
            $table->integer('unit_lifetime_km')->default(0);
            $table->integer('tire_lifetime_hm')->default(0);
            $table->integer('tire_lifetime_km')->default(0);
            $table->integer('rtd')->unsigned()->default(0);

            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            $table->string('pic')->nullable();
            $table->string('pic_man_power')->nullable();
            $table->string('desc')->nullable();

            $table->string('start_breakdown')->nullable();
            $table->string('status_breakdown')->nullable()   ;
            $table->string('lokasi_breakdown')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_movements');
    }
};
