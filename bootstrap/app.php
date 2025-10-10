<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php', // ✅ tambahkan ini biar route API aktif
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tempat untuk daftarkan middleware global atau grup middleware
        // Misal: $middleware->web([...]) atau $middleware->api([...]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tempat untuk handle exception kustom
        // Misal: $exceptions->reportable(fn (Throwable $e) => ...);
    })
    ->create();
