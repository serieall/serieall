<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class NavActiveLoginComposer
 * @package App\Http\ViewComposers
 */
class NavActiveLoginComposer
{
    private $navActive;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->navActive = 'login';
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