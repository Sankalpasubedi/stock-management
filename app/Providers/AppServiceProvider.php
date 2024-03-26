<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Vendor;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use mysql_xdevapi\Schema;

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
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);


        Relation::morphMap([
           'vendor'=>Vendor::class,
            'customer'=>Customer::class
        ]);
    }
}
