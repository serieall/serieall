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
        // ADMINISTRATION
        // NavActive = AdminHome
        View::composer(
            ['admin/index','admin/log'],
            'App\Http\ViewComposers\NavActiveAdminHomeComposer'
        );

        // NavActive = AdminShows
        View::composer(
            ['admin/shows/*', 'admin/artists/*'],
            'App\Http\ViewComposers\NavActiveAdminShowsComposer'
        );

        // NavActive = AdminSystem
        View::composer(
            ['admin/system/*'],
            'App\Http\ViewComposers\NavActiveAdminSystemComposer'
        );

        // SITE
        // NavActive = home
        View::composer(
            ['home'],
            'App\Http\ViewComposers\NavActiveHomeComposer'
        );

        // NavActive = login
        View::composer(
            ['auth/login', 'auth/passwords/*'],
            'App\Http\ViewComposers\NavActiveLoginComposer'
        );

        // NavActive = register
        View::composer(
            ['auth/register'],
            'App\Http\ViewComposers\NavActiveRegisterComposer'
        );

        // NavActive = profil
        View::composer(
            ['users/*'],
            'App\Http\ViewComposers\NavActiveProfilComposer'
        );

        // NavActive = shows
        View::composer(
            ['shows/*'],
            'App\Http\ViewComposers\NavActiveShowsComposer'
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