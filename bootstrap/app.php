<?php

use App\Http\Middleware\ForceJsonHeader;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            "header.json" => ForceJsonHeader::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, $request) {
            if($request->is('api/*')) {
                return response()->json([
                    "message" => "Resource not found."
                ], 404);
            }
        });
        $exceptions->render(function (AccessDeniedHttpException $e, $request) {
            if($request->is('api/*')) {
                return response()->json([
                    "message" => "This action is unauthorized."
                ], 403);
            }
        });
    })->create();
