<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CustomerDetail;
use App\Models\TransactionDetail;
use App\Observers\AuditObserver;

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
        // Register Audit Observer for tracked models
        CustomerDetail::observe(AuditObserver::class);
        TransactionDetail::observe(AuditObserver::class);
    }
}
