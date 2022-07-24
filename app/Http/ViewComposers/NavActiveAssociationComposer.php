<?php

declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class NavActiveAssociationComposer.
 */
class NavActiveAssociationComposer
{
    private $navActive;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->navActive = 'association';
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navActive', $this->navActive);
    }
}
