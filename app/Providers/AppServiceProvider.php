<?php

namespace App\Providers;

use App\Models\AcademicYear;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->share('academicYear', AcademicYear::current());
        Schema::defaultStringLength(191);
    }
}
