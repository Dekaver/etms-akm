<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GrafikController;
use App\Http\Controllers\HistoryTireMovementController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TireTargetKmController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TireManufactureController;
use App\Http\Controllers\TirePatternController;
use App\Http\Controllers\TireSizeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TireCompoundController;
use App\Http\Controllers\TireStatusController;
use App\Http\Controllers\TireDamageController;
use App\Http\Controllers\TireMasterController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\UnitStatusController;
use App\Http\Controllers\UnitModelController;
use App\Http\Controllers\TireRepairController;
use App\Http\Controllers\TireRunningController;
use App\Http\Controllers\DailyInspectController;
use App\Http\Controllers\HistoryTireController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware(['permission:USER_MANAJEMEN', 'role:superadmin'])->group(function () {
        Route::post('user/{id}/company', [UserController::class, 'updateCompany'])->name('user.company.update');
    });
    Route::middleware(['permission:USER_MANAJEMEN'])->group(function () {
        Route::resource('user', UserController::class);
        Route::resource('permission', PermissionController::class)->middleware('permission:PERMISSION');
        Route::resource('role', RoleController::class)->middleware('permission:ROLE');
    });
    Route::resource('company', CompanyController::class)->middleware('permission:COMPANY');

    Route::get('user/{id}/permission', [UserController::class, 'indexPermission'])->name('user.permission.index');
    Route::post('user/{id}/permission/', [UserController::class, 'updatePermission'])->name('user.permission.update');
    Route::resource('unit', UnitController::class);

    Route::resource('tiremanufacture', TireManufactureController::class)->middleware('permission:TIRE_MANUFACTURE');
    Route::resource('tirepattern', TirePatternController::class)->middleware('permission:TIRE_PATTERN');
    Route::resource('tiresize', TireSizeController::class)->middleware('permission:TIRE_SIZE');
    Route::resource('tirecompound', TireCompoundController::class)->middleware('permission:TIRE_COMPOUND');
    Route::resource('tirestatus', TireStatusController::class)->middleware('permission:TIRE_STATUS');
    Route::resource('tiredamage', TireDamageController::class)->middleware('permission:TIRE_DAMAGE');
    Route::resource('tiremaster', TireMasterController::class)->middleware('permission:TIRE_MASTER');
    Route::resource('tiretargetkm', TireTargetKmController::class)->middleware('permission:TIRE_TARGETKM');



    Route::resource('site', SiteController::class)->middleware('permission:SITE');
    Route::resource('unitstatus', UnitStatusController::class)->middleware('permission:UNIT_STATUS');
    Route::resource('unitmodel', UnitModelController::class)->middleware('permission:UNIT_MODEL');
    Route::resource('unit', UnitController::class)->middleware('permission:UNIT');

    Route::resource('tirerepair', TireRepairController::class)->middleware('permission:TIRE_REPAIR');
    Route::resource('tirerunning', TireRunningController::class)->middleware('permission:TIRE_RUNNING');

    Route::resource('dailyinspect', DailyInspectController::class)->middleware('permission:DAILY_INSPECT');

    Route::resource('historytire', HistoryTireController::class)->middleware('permission:HISTORY_TIRE');

    Route::resource('historytiremovement', HistoryTireMovementController::class)->middleware('permission:HISTORY_TIRE_MOVEMENT');
    Route::get('tiremovement/{tire}/history', [HistoryTireMovementController::class, 'tiremovement'])
        ->name('historytiremovement.tiremovement')
        ->middleware('permission:HISTORY_TIRE_MOVEMENT');
    Route::get('tireinspect/{tire}/history', [HistoryTireMovementController::class, 'tireinspect'])
        ->name('historytiremovement.tireinspect')
        ->middleware('permission:HISTORY_TIRE_MOVEMENT');

    Route::middleware(['permission:GRAFIK'])->group(function () {
        Route::get('grafik-check-pressure-hd', [GrafikController::class, 'checkPressureHd']);
        Route::get('grafik-check-rtd', [GrafikController::class, 'checkRTD']);
        Route::get('grafik-check-pressure-support', [GrafikController::class, 'checkPressureSupport']);
        Route::get('grafik-tire-inflation', [GrafikController::class, 'tireInflation']);
        Route::get('grafik-tire-inventory', [GrafikController::class, 'tireInventory']);
        Route::get('grafik-tire-consumption-by-unit', [GrafikController::class, 'tireConsumptionByModelUnit']);
        // Route::get('grafik-tire-cost-perhm', [GrafikController::class, 'tireCostPerHM']);
        // Route::get('grafik-tire-cost-perkm', [GrafikController::class, 'tireCostPerKM']);
        // Route::get('grafik-tire-cost-per-hm-by-pattern', [GrafikController::class, 'tireCostPerHMByPattern']);
        // Route::get('grafik-tire-cost-per-km-by-pattern', [GrafikController::class, 'tireCostPerKMByPattern']);
        Route::get('grafik-tire-scrap-injury', [GrafikController::class, 'tireScrapInjury']);
        Route::get('grafik-tire-scrap-injury-cause', [GrafikController::class, 'tireScrapInjuryCause']);
        // Route::get('grafik-tire-runnning-conditional-hm', [GrafikController::class, 'tireRunningConditionalHm']);
        // Route::get('grafik-brand-usage', [GrafikController::class, 'brandUsage']);
        Route::get('grafik-tire-lifetime-average-km', [GrafikController::class, 'tireLifetimeAverageKM']);
        Route::get('grafik-tire-lifetime-average-hm', [GrafikController::class, 'tireLifetimeAverageHM']);
        Route::get('tire-performance', [DashboardController::class, 'tirePerformance'])->name('tire-performance');
        // Route::get('tire-maintenance', [DashboardController::class, 'tireMaintenance']);
        Route::get('tire-scrap', [DashboardController::class, 'tireScrap'])->name('tire-scrap');
        Route::get('tire-cause-damage', [DashboardController::class, 'tireCauseDamage'])->name('tire-cause-damage');

        Route::get('grafik-tire-cause-damage', [GrafikController::class, 'tireCauseDamage']);
        Route::get('grafik-tire-cause-damage-injury', [GrafikController::class, 'tireCauseDamageInjury']);
        // AKM
        Route::get('grafik-tire-fitment', [GrafikController::class, 'tireFitment']);
        Route::get('grafik-tire-fitment-month', [GrafikController::class, 'tireFitmentMonth']);
        Route::get('grafik-tire-fitment-week', [GrafikController::class, 'tireFitmentWeek']);
        Route::get('grafik-tire-removed', [GrafikController::class, 'tireRemoved']);
        Route::get('grafik-tire-removed-month', [GrafikController::class, 'tireRemovedMonth']);
        Route::get('grafik-tire-removed-week', [GrafikController::class, 'tireRemovedWeek']);

    });

    //EXPORT
    Route::middleware(['permission:EXPORT'])->group(function () {
        Route::get('report-daily-inspect-export', [DailyInspectController::class, 'export'])->name('daily-inspect.export');
    });

    Route::middleware(['permission:IMPORT'])->group(function () {
        Route::get('daily-inspect-import', [DailyInspectController::class, 'importView'])->name('daily-inspect.import');
        Route::POST('daily-inspect-import', [DailyInspectController::class, 'import'])->name('daily-inspect.import.store');
    });

    //REPORT
    Route::middleware(['permission:REPORT'])->group(function () {
        Route::get('report-tire-activity', [ReportController::class, 'tireActivity'])->name('report.activity');
        Route::get('report-tire-status', [ReportController::class, 'statusTireCount'])->name('report.tirestatus');
        Route::get('report-tire-target-km', [ReportController::class, 'tireTargetKm'])->name('report.tiretargetkm');
        Route::get('report-tire-running', [ReportController::class, 'tireRunning'])->name('report.tirerunning');
        Route::get('report-tire-inventory', [ReportController::class, 'tireInventory'])->name('report.tireinventory');
        Route::get('report-tire-rtd-per-unit', [ReportController::class, 'tireRtdPerUnit'])->name('report.tirertdperunit');
    });

    Route::middleware(['permission:ADJUSTKMPASANG'])->group(function(){
        Route::post('adjust-km-pasang', [TireRunningController::class, 'adjustKmPasang'])->name('adjust-km-pasang.store');
    });

    Route::middleware(['permission:RESETTIREHISTORY'])->group(function(){
        Route::post('tire-reset/{tiremaster}', [TireMasterController::class, 'resetHistory'])->name('tiremaster.reset');
    });

    // Route::get('tiremaster', TireMasterController::class)->middleware('permission:TIRE_MASTER');
});

Route::get('aaaa', function () {
    // $a = \App\Models\TireSize::where("company_id", 1)->get();
    // foreach ($a as $key => $value) {
    //     dd($value, $value->tire_pattern);
    //     $value = $value->replicate();
    //     $value->company_id = 2;
    //     // $value->save();
    // }
});

require __DIR__ . '/auth.php';
