<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \App\Models\BlogPost::observe(\App\Observers\BlogPostObserver::class);
        \App\Models\BlogCategory::observe(\App\Observers\BlogCategoryObserver::class);
    }
}
