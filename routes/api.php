<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\V1\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->name('v1.')->group(function (): void {
    Route::get('/status', StatusController::class)->name('status');
});

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/tools', [ToolController::class, 'index'])->name('tools.index');
Route::get('/tools/popular', [ToolController::class, 'popular'])->name('tools.popular');
Route::get('/tools/featured', [ToolController::class, 'featured'])->name('tools.featured');
Route::get('/tools/search', [ToolController::class, 'search'])->name('tools.search');
Route::get('/tools/{slug}', [ToolController::class, 'show'])->name('tools.show');
