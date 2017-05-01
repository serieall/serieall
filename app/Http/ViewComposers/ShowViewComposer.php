<?php

namespace App\Http\ViewComposers;

use App\Repositories\ShowRepository;
use Illuminate\View\View;

class ShowViewComposer
{
    protected $showRepository;

    /**
     * Create a new profile composer.
     *
     * @param ShowRepository $showRepository
     * @internal param ShowRepository $shows
     */
    public function __construct(ShowRepository $showRepository)
    {
        // Dependencies automatically resolved by service container...
        $this->showRepository = $showRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $shows = $this->showRepository->getShowDropdown();
        $view->with('shows', end($shows));
    }
}