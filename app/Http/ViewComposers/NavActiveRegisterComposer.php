<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * Class NavActiveRegisterComposer
 * @package App\Http\ViewComposers
 */
class NavActiveRegisterComposer
{
    private $navActive;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->navActive = 'register';
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