<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom pic_id jika belum ada pada tabel tire_movements
        if (!Schema::hasColumn('tire_movements', 'pic_id')) {
            Schema::table('tire_movements', function (Blueprint $table) {
                $table->foreignId('pic_id')->nullable()->constrained('teknisis');
            });
        }

        // Tambah kolom pic_id jika belum ada pada tabel history_tire_movements
        if (!Schema::hasColumn('history_tire_movements', 'pic_id')) {
            Schema::table('history_tire_movements', function (Blueprint $table) {
                $table->foreignId('pic_id')->nullable()->constrained('teknisis');
                $table->string('pic')->nullable()->change();
                $table->string('pic_man_power')->nullable()->change();
            });
        }

        // Tambah kolom pic_id dan driver_id jika belum ada pada tabel daily_inspects
        if (!Schema::hasColumn('daily_inspects', 'pic_id')) {
            Schema::table('daily_inspects', function (Blueprint $table) {
                $table->foreignId('pic_id')->nullable()->constrained('teknisis');
                $table->foreignId('driver_id')->nullable()->constrained('drivers');
                $table->date('date')->nullable()->change();
                $table->time('time')->nullable()->change();
                $table->dateTime("start_date")->nullable();
                $table->dateTime("end_date")->nullable();
            });
        }
    }

    public function down(): void
    {
        Schema::table('tire_movements', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropColumn('pic_id');
        });
        Schema::table('history_tire_movements', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropColumn('pic_id');
            $table->string('pic')->nullable(false)->change();
            $table->string('pic_man_power')->nullable(false)->change();
        });
        Schema::table('daily_inspects', function (Blueprint $table) {
            $table->dropForeign(['pic_id']);
            $table->dropColumn('pic_id');
            $table->dropForeign(['driver_id']);
            $table->dropColumn('driver_id');
            $table->date('date')->nullable(false)->change();
            $table->time('time')->nullable(false)->change();
            $table->dropColumn("start_date");
            $table->dropColumn("end_date");
        });
    }
};
