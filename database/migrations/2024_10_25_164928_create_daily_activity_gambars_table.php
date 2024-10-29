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
        if (!Schema::hasTable('daily_activity_gambars')) {
            Schema::create('daily_activity_gambars', function (Blueprint $table) {
                $table->id();
                $table->foreignId("daily_activity_id")->constrained("daily_activities")->onDelete('cascade');
                $table->string("gambar");
                $table->timestamps();
            });
        }
    }    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_activity_gambars');
    }
};
