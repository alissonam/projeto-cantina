<?php

use Illuminate\Support\Facades\Route;
use Items\ItemController;

Route::group([
    'middleware' => ['auth:sanctum', 'user_checker']
], function () {
    Route::apiResource('items', ItemController::class);
});
