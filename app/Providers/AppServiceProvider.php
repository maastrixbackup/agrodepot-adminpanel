<?php

namespace App\Providers;

use App\Models\cmsPage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        //
        $titleArray = cmsPage::select('id', 'title')->get();

        Schema::defaultStringLength(191);
        View::share('menus', $titleArray);
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
