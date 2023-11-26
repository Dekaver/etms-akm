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
        Schema::table('sites', function (Blueprint $table) {
            $table->integer("jarak_hauling")->nullable()->after("name");
            $table->integer("rit_per_hari")->nullable()->after("name");
            $table->integer("total_jarak")->nullable()->after("name");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sites', function (Blueprint $table) {
            $table->dropColumn('jarak_hauling');
            $table->dropColumn('rit_per_hari');
            $table->dropColumn('total_jarak');

        });
    }
};
