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
        Schema::create('tire_runnings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained("units");
            $table->foreignId('tire_id')->constrained("tires");
            $table->foreignId('site_id')->constrained('sites');
            $table->foreignId('company_id')->constrained('companies');
            $table->integer('position')->unsigned()->default(0);
            $table->timestamps();
            $table->unique(["unit_id","tire_id","site_id","company_id","position",]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_runnings');
    }
};
