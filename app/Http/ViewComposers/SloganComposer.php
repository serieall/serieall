<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use App\Models\Slogan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class NavActiveShowsComposer
 * @package App\Http\ViewComposers
 */
class SloganComposer
{
    private $slogan;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->slogan = [];
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $this->slogan = Slogan::inRandomOrder()->first();

        $view->with('slogan', $this->slogan);
    }
}