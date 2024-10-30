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
        Schema::create('daily_activities', function (Blueprint $table) {
            $table->id();
            $table->date("tanggal");
            $table->foreignId("site_id")->constrained("sites");
            $table->foreignId("teknisi_id")->constrained("teknisis");
            $table->foreignId("aktivitas_pekerjaan_id")->constrained("aktivitas_pekerjaans");
            $table->foreignId("unit_model_id")->nullable()->constrained("unit_models");
            $table->foreignId("unit_id")->nullable()->constrained("units");
            $table->dateTime("start_date");
            $table->dateTime("end_date");
            $table->foreignId("area_pekerjaan_id")->constrained("area_pekerjaans");
            $table->text("remark")->nullable();
            $table->foreignId('company_id')->constrained('companies');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activities');
    }
};
