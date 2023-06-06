<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TireController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TireManufactureController;
use App\Http\Controllers\TirePatternController;
use App\Http\Controllers\TireSizeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;

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
    return view('welcome');
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
    Route::resource("tirepattern", TirePatternController::class);
    Route::resource("tiresize", TireSizeController::class);
});
require __DIR__ . '/auth.php';