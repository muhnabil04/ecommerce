<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Http\Resources\Json\PaginatedResourceResponse;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Pagination;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    }
}
