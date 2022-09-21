<?php

use Illuminate\Support\Facades\Route;
use Orders\OrderController;

Route::group([
    'middleware' => ['auth:sanctum', 'user_checker']
], function () {
    Route::apiResource('orders', OrderController::class);
});
