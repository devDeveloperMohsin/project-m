<?php

namespace App\Providers;

use App\View\Composers\MarkedProjectsComposer;
use App\View\Composers\MarkedWorkspacesComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer(['layouts.sidebar', 'workspaceDetails'], MarkedWorkspacesComposer::class);
        View::composer(['layouts.sidebar', 'projectDetails'], MarkedProjectsComposer::class);
    }
}
