<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DisheController;
use App\Http\Controllers\GallaryController;
use App\Http\Controllers\CalendarController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
    return redirect()->route('login');
    });
    Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/menu', [MenuController::class, 'index'])->name('menu');
    Route::post('/add-category', [MenuController::class, 'addCategory'])->name('addCategory');
    Route::post('/create-menu', [MenuController::class, 'createMenu'])->name('createMenu');
    Route::delete('/delete-menu/{id}', [MenuController::class, 'delete'])->name('deleteMenu');
    Route::get('/calendar', [CalendarController::class, 'overview'])->name('calendar');
    Route::prefix('menu')->group(function () {
        Route::get('/view/{slug}', [DisheController::class, 'index'])->name('menu.view');
        Route::post('/add-dish/{menuId}', [DisheController::class, 'add'])->name('dish.add');
        Route::delete('/delete-dish/{menuId}', [DisheController::class, 'delete'])->name('dish.delete');
    });
        Route::prefix('gallery')->group(function () {
            Route::get('/', [GallaryController::class, 'index'])->name('gallery.view');
            Route::post('/add-dish/{menuId}', [DisheController::class, 'add'])->name('dish.add');
            Route::delete('/delete-dish/{menuId}', [DisheController::class, 'delete'])->name('dish.delete');
        });
});
require __DIR__ . '/auth.php';
