<?php

declare(strict_types=1);

namespace App\Http\ViewComposers;

use App\Models\Show;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class FollowedShowsComposer.
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
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $this->followed_shows = Show::join('show_user', 'shows.id', '=', 'show_user.show_id')
            ->join('users', 'users.id', '=', 'show_user.user_id')
            ->orderBy('shows.name')
        ->where('users.id', '=', Auth::user()->id)
        ->where('show_user.state', '=', 1)
            ->select(DB::raw('shows.name as name, shows.show_url as show_url'))
            ->get();
        }

        $view->with('followed_shows', $this->followed_shows);
    }
}
