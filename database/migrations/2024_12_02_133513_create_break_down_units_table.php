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
        Schema::create('breakdown_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->nullable()->constrained("companies");
            $table->date("tanggal")->nullable();
            $table->string("shift")->nullable();
            $table->string("unit")->nullable(); //referensi unit
            $table->string("pit")->nullable();
            $table->foreignId("site_id")->nullable()->constrained("sites");
            $table->double("hm_bd")->default(0)->nullable();
            $table->double("hm_ready")->default(0)->nullable();
            $table->date("start_bd_date")->nullable();
            $table->double("start_bd")->default(0)->nullable();
            $table->double("end_bd")->default(0)->nullable();
            $table->double("duration_bd")->default(0)->nullable();
            $table->string("status_bd")->nullable();
            $table->text("problem")->nullable();
            $table->text("action")->nullable();
            $table->string("pb_vendor")->nullable();
            $table->string("mr_ro_po")->nullable();
            $table->string("section")->nullable();
            $table->string("component")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breakdown_units');
    }
};
