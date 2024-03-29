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
            $table->id();
            $table->foreignId("company_id")->constrained("companies");
            $table->string("name");
            $table->timestamps();
            $table->unique(["company_id", "name"]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tire_manufactures');
    }
};
