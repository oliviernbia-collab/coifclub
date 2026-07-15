<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    protected $middlewareAliases = [
        // autres middleware...

        'role' => \App\Http\Middleware\RoleMiddleware::class,
        'localize' => \App\Http\Middleware\SetLocale::class,
    ];
}
