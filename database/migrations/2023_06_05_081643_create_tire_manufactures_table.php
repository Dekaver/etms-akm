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
        Schema::create('tire_manufactures', function (Blueprint $table) {
            $table->engine = "MyISAM";
            $table->integer("id")->unsigned();
            $table->integer("company_id")->unsigned();
            $table->string("name");
            $table->timestamps();
            $table->primary(array("id", "company_id"));
        });

        DB::statement('ALTER TABLE tire_manufactures MODIFY id INTEGER NOT NULL AUTO_INCREMENT');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_manufactures');
    }
};
