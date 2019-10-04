<?php
declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Show;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class FollowedShowsComposer
 * @package App\Http\ViewComposers
 */
class FollowedShowsComposer
{
    private $followed_shows;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->followed_shows = [];
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(Auth::check()) {
            $this->followed_shows = Show::join('show_user', 'shows.id', '=', 'show_user.show_id')
            ->join('users', 'users.id', '=', 'show_user.user_id')
            ->orderBy('shows.name')
            ->where('users.id', '=', Auth::user()->id)
            ->select(DB::raw('shows.name as name, shows.show_url as show_url'))
            ->get();
        }
        Log::info($this->followed_shows);

        $view->with('followed_shows', $this->followed_shows);
    }
}