<?php

use Illuminate\Support\Facades\Route;
use NemanjaIlic\ModelDeactivator\Http\Controllers\TemporaryDeactivateController;

Route::group(['middleware' => ['web']], function () {
    Route::post('/temporarily-deactivator/deactivate', [TemporaryDeactivateController::class, 'store'])
        ->name('deactivator.store');
});