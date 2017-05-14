<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class StandardComposer
{

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        $this->folderImages = config('directories.images');
        $this->folderShows = config('directories.shows');

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('folderImages', $this->folderImages)->with('folderShows', $this->folderShows);
    }
}