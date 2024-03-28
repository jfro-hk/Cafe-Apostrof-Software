<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('make-res/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK',[\App\Http\Controllers\ApiController::class,'add']);
Route::get('/get-gallery/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK',[\App\Http\Controllers\ApiController::class,'getGallery']);
Route::get('/get-gallery',[\App\Http\Controllers\GalleryController::class,'getGallery']);
Route::get('/get-menu/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK',[\App\Http\Controllers\ApiController::class,'getMenu']);
Route::get('/get-dishes/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK',[\App\Http\Controllers\ApiController::class,'getDishes']);
Route::get('/get-categories/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK',[\App\Http\Controllers\ApiController::class,'getCategories']);
Route::get('/get-settings/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK', [\App\Http\Controllers\ApiController::class, 'getSettings'])->name('settings.get');
Route::get('/get-tables/{date}/{time}/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK', [\App\Http\Controllers\ApiController::class, 'getTables'])->name('getTables');
Route::post('/make-res/$2a$12$cAZSHYq3zV0CbnaolVBMJeTRTPpBTKbiQSFMRKkU2WrAHQD4KiSeK', [\App\Http\Controllers\ApiController::class, 'add'])->name('make-res');
