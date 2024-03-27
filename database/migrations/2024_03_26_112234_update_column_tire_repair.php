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
        Schema::table('tire_repairs', function (Blueprint $table) {
            $table->foreignId("history_tire_movement_id")->nullable()->constrained("history_tire_movements");
            $table->foreignId("tire_damage_2_id")->nullable()->constrained("tire_damages");
            $table->foreignId("tire_damage_3_id")->nullable()->constrained("tire_damages");

            $table->string("foto_after_1")->nullable();
            $table->text("keterangan_after_1")->nullable();

            $table->string("foto_before_1")->nullable();
            $table->text("keterangan_before_1")->nullable();

            $table->string("foto_after_2")->nullable();
            $table->text("keterangan_after_2")->nullable();

            $table->string("foto_before_2")->nullable();
            $table->text("keterangan_before_2")->nullable();

            $table->string("foto_after_3")->nullable();
            $table->text("keterangan_after_3")->nullable();

            $table->string("foto_before_3")->nullable();
            $table->text("keterangan_before_3")->nullable();

            });

            // Schema::create('tire_repair_photos', function (Blueprint $table) {
            //     $table->id();
            //     $table->foreignId("tire_repair_id")->constrained("tire_repairs");
            //     $table->string("photo");
            //     $table->integer("urut")->default(0);
            //     $table->char("tipe");
            // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('tire_repairs', function (Blueprint $table) {
        //     $table->dropColumn("history_tire_movements_id");
        //     $table->dropColumn("tire_damage_2_id");
        //     $table->dropColumn("tire_damage_3_id");
        // });
    }
};
