<?php

declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class FicheActiveDetailsComposer.
 */
class FicheActiveDetailsComposer
{
    private $FicheActive;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->FicheActive = 'details';
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('FicheActive', $this->FicheActive);
    }
}
