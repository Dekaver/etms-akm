<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tire_masters', function (Blueprint $table) {

            $table->engine="MyISAM";
            $table->integer("id")->unsigned();
            $table->integer("company_id")->unsigned();
            $table->integer("site_id")->unsigned();
            $table->string("serial_number");
            $table->integer("tire_size_id")->unsigned();
            $table->integer("tire_compound_id")->unsigned();
            $table->integer("tire_status_id")->unsigned();
            $table->integer("lifetime");
            $table->integer("rtd");
            $table->date("date");

            $table->timestamps();
            $table->primary(array("id", "company_id"));
        });
        DB::statement('ALTER TABLE tire_masters MODIFY id INTEGER NOT NULL AUTO_INCREMENT');

    }

    public function down(): void
    {
        Schema::dropIfExists('tire_masters');
    }
};
