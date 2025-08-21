<?php

namespace App\Bootstrappers;

use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

class MiddlewareBootstrapper
{
    public function __invoke(Middleware $middleware): void
    {
        $middleware->web(append: [
            AddLinkHeadersForPreloadedAssets::class,
        ]);
    }
}
