<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(\App\Http\Api\Response\Builder\ApiResponseBuilder::class);
        $this->app->singleton(\App\Http\Api\Response\Builder\SuccessResponseBuilder::class);
        $this->app->singleton(\App\Http\Api\Response\Builder\ErrorResponseBuilder::class);
    }
}
