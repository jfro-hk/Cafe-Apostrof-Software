<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\DisheController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\SettingsController;
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
    Route::post('/add-category/{menuId}', [MenuController::class, 'addCategory'])->name('addCategory');
    Route::delete('/delete-category/{id}', [MenuController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/create-menu', [MenuController::class, 'createMenu'])->name('createMenu');
    Route::delete('/delete-menu/{id}', [MenuController::class, 'delete'])->name('deleteMenu');
    Route::post('/update-menu/{id}', [MenuController::class, 'update'])->name('updateMenu');
    Route::prefix('menu')->group(function () {
        Route::get('/view/{slug}', [DisheController::class, 'index'])->name('menu.view');
        Route::post('/add-dish/{menuId}', [DisheController::class, 'add'])->name('dish.add');
        Route::post('/add-img/{menuId}', [DisheController::class, 'addImage'])->name('dish.addImage');
        Route::post('/update-dish/{id}', [DisheController::class, 'update'])->name('dish.update');
        Route::delete('/delete-dish/{menuId}', [DisheController::class, 'delete'])->name('dish.delete');
    });
//        Route::prefix('gallery')->group(function () {
    Route::get('/gallerys', [GalleryController::class, 'index'])->name('gallery.view');
    Route::get('/get-gallery-json', [GalleryController::class, 'getGallery']);
    Route::post('/add-gallery', [GalleryController::class, 'add'])->name('gallery.add');
    Route::post('/update-gallery/{id}', [GalleryController::class, 'update'])->name('gallery.update');
    Route::post('/delete-gallery/{id}', [GalleryController::class, 'delete'])->name('gallery.delete');
    // Events
    Route::get('/calendar', [EventController::class, 'overview'])->name('calendar');
    Route::post('/add-event/', [EventController::class, 'add'])->name('event.add');
    Route::post('/update-event/{id}', [EventController::class, 'update'])->name('event.update');
    Route::delete('/delete-event/{id}', [EventController::class, 'deleteEvent'])->name('event.delete');
    Route::get('/get-events', [EventController::class, 'getEvents'])->name('event.get');

    Route::post('/settings-update/{id}', [SettingsController::class, 'update'])->name('settings.update');

//        });
});
require __DIR__ . '/auth.php';
