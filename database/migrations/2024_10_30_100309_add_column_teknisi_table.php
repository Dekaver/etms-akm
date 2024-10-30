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
        Schema::table('teknisis', function (Blueprint $table) {
            $table->boolean("is_leader")->default(false)->after('company_id');
            $table->boolean("is_foreman")->default(false)->after('company_id');
            $table->boolean("is_manpower")->default(false)->after('company_id');
            $table->string("nik")->nullable()->after('company_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('teknisis', function (Blueprint $table) {
            $table->dropColumn('is_leader');
            $table->dropColumn('is_foreman');
            $table->dropColumn('is_manpower');
            $table->dropColumn('nik');
        });
    }
};
