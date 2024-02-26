<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DisheController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/update-menu/{id}', [MenuController::class, 'update'])->name('updateMenu');
    Route::prefix('menu')->group(function () {
        Route::get('/view/{slug}', [DisheController::class, 'index'])->name('menu.view');
        Route::post('/add-dish/{menuId}', [DisheController::class, 'add'])->name('dish.add');
        Route::post('/update-dish/{id}', [DisheController::class, 'update'])->name('dish.update');
        Route::delete('/delete-dish/{menuId}', [DisheController::class, 'delete'])->name('dish.delete');
    });
//        Route::prefix('gallery')->group(function () {
    Route::get('/gallerys', [GalleryController::class, 'index'])->name('gallery.view');
    Route::post('/add-gallery', [GalleryController::class, 'add'])->name('gallery.add');
    Route::post('/update-gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/delete-gallery/{id}', [GalleryController::class, 'delete'])->name('gallery.delete');
    // Events
    Route::get('/calendar', [EventController::class, 'overview'])->name('calendar');
    Route::post('/add-event', [EventController::class, 'add'])->name('event.add');
    Route::post('/get-events', [EventController::class, 'getEvents'])->name('event.get');

//        });
});
require __DIR__ . '/auth.php';
