<?php

declare(strict_types=1);

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Class NavActiveShowsComposer.
 */
class UnreadNotificationsComposer
{
    private $unread_notifications;

    /**
     * AdminViewComposer constructor.
     */
    public function __construct()
    {
        // Dependencies automatically resolved by service container...
        $this->unread_notifications = [];
    }

    /**
     * Bind data to the view.
     *
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $this->unread_notifications = Auth::user()->unreadNotifications;
        }

        $view->with('unread_notifications', $this->unread_notifications);
    }
}
