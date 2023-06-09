<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tires', function (Blueprint $table) {
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->foreignId("site_id")->constrained("sites");
            $table->string("serial_number");
            $table->foreignId("tire_supplier_id")->constrained("tire_suppliers");
            $table->foreignId("tire_size_id")->constrained("tire_sizes");
            $table->foreignId("tire_compound_id")->constrained("tire_compounds");
            $table->foreignId("tire_status_id")->constrained("tire_statuses");
            $table->integer("lifetime");
            $table->tinyInteger("rtd");
            $table->date("date");
            $table->timestamps();
            $table->unique(["company_id", "serial_number"]);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('tires');
    }
};
