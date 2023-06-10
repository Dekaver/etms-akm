<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TireController;
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
use App\Http\Controllers\TireMovementController;
use App\Http\Controllers\TireDisposisiController;
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
    return redirect()->route("login");
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->group(function () {
    Route::resource("tire", TireController::class);
    Route::resource("user", UserController::class);
    Route::get("user/{id}/permission", [UserController::class, "indexPermission"])->name('user.permission.index');
    Route::post("user/{id}/permission/", [UserController::class, "updatePermission"])->name('user.permission.update');
    Route::resource("unit", UnitController::class);
    Route::resource("dashboard", DashboardController::class);
    Route::resource("tiremanufacture", TireManufactureController::class)->middleware("permission:TIRE_MANUFACTURE");
    Route::resource("tirepattern", TirePatternController::class)->middleware("permission:TIRE_PATTERN");
    Route::resource("tiresize", TireSizeController::class);
    Route::resource("tirecompound", TireCompoundController::class);
    Route::resource("tirestatus", TireStatusController::class);
    Route::resource("tiredamage", TireDamageController::class);
    Route::resource("tiremaster", TireMasterController::class);

    Route::resource("site", SiteController::class);
    Route::resource("unitstatus", UnitStatusController::class);
    Route::resource("unitmodel", UnitModelController::class);
    Route::resource("unit", UnitController::class);

    Route::resource("tirerunning", TireRunningController::class);

    Route::resource("tiredisposisi", TireDisposisiController::class);
    Route::resource("tirerepair", TireRepairController::class);
    Route::resource("tirerunning", TireRunningController::class);

    Route::resource("dailyinspect", DailyInspectController::class);
    Route::resource("historytire", HistoryTireController::class);
});
Route::resource("permission", PermissionController::class);
Route::resource("role", RoleController::class);
require __DIR__ . '/auth.php';
