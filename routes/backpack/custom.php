<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PickingCrudController;
use App\Http\Controllers\Admin\TaushCrudController;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('picking', 'PickingCrudController');
    Route::post('picking/import-pickings', [PickingCrudController::class, 'import'])->name('picking.import');
    Route::crud('taush', 'TaushCrudController');
    Route::post('taush/import-taushes', [TaushCrudController::class, 'import'])->name('taush.import');
}); // this should be the absolute last line of this file