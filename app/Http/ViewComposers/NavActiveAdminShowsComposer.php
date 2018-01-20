<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class NavActiveAdminShowsComposer
 * @package App\Http\ViewComposers
 */
class NavActiveAdminShowsComposer
{
    private $navActive;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->navActive = 'AdminShows';
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('navActive', $this->navActive);
    }
}