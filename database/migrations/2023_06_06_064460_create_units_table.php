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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("unit_model_id")->constrained("unit_models");
            $table->foreignId("unit_status_id")->constrained("unit_statuses");
            $table->foreignId("site_id")->constrained("sites");
            $table->string("unit_number");
            $table->string("head");
            $table->enum("jenis", ["km", "hm"]);
            $table->integer("km");
            $table->integer("hm");
            $table->unique(["company_id", "unit_number"]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
