<?php

declare(strict_types=1);

use App\Api;
use Yiisoft\Router\Route;

/**
 * @var array $params
 */

return [
    Route::get('/')->action(Api\IndexAction::class)->name('app/index'),
    Route::post('/login')->action(Api\LoginAction::class)->name('app/login'),
    Route::get('/bearer')->middleware(\App\Middleware\AuthMiddleware::class)->action(Api\BearerAction::class)->name('app/bearer'),
];
