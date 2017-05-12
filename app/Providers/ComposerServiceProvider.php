<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            ['admin/index','admin/log'],
            'App\Http\ViewComposers\NavActiveAdminHomeComposer'
        );

        View::composer(
            ['admin/shows/indexShows','admin/shows/edit','admin/shows/createManually','admin/shows/addShow'],
            'App\Http\ViewComposers\NavActiveAdminShowsComposer'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}