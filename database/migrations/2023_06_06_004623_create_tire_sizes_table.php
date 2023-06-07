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
        Schema::create('tire_sizes', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();

            $table->engine="MyISAM";
            $table->integer("id")->unsigned();
            $table->integer("company_id")->unsigned();
            $table->integer("tire_pattern_id")->unsigned();
            $table->string("size");
            $table->integer("otd");
            $table->integer("recomended_pressure");
            $table->integer("target_lifetime");
            $table->timestamps();
            $table->primary(array("id", "company_id"));
        });
        DB::statement('ALTER TABLE tire_sizes MODIFY id INTEGER NOT NULL AUTO_INCREMENT');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_sizes');
    }
};
