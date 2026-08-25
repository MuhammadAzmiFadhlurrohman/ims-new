<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception, \Illuminate\Http\Request $request) {
            if ($response->getStatusCode() === 419) {
                if ($request->is('portal*') || str_contains($request->url(), '/portal')) {
                    return redirect()->guest(route('customer.portal'))->with('error', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
                }
                return redirect()->guest(url('/admin/login'))->with('error', 'Sesi Anda telah berakhir. Silakan masuk kembali.');
            }
            return $response;
        });
    })->create();
