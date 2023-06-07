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
        Schema::create('tire_patterns', function (Blueprint $table) {
            $table->engine="MyISAM";
            $table->integer("id")->unsigned();
            $table->integer("id_company")->unsigned();
            $table->string("pattern");
            $table->string("type_pattern");
            $table->integer("tire_manufacture_id")->unsigned();
            $table->timestamps();
            $table->primary(array("id", "id_company"));
        });
        DB::statement('ALTER TABLE tire_patterns MODIFY id INTEGER NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_patterns');
    }
};
