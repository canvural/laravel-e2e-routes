<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Vural\E2ERoutes\Http\Controller\FactoryController;
use Vural\E2ERoutes\Http\Controller\ResetController;

Route::prefix((string) config('e2e-routes.prefix'))->name(config('e2e-routes.name') . '.')->group(static function () : void {
    Route::get('reset', ResetController::class)->name('reset');

    Route::post('{factoryName}', FactoryController::class);
});
