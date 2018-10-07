<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Notifications\ReplyContactNotification;
use App\Repositories\ContactRepository;

use App\Http\Requests\ReplyContactRequest;
use App\Repositories\SloganRepository;
use Illuminate\Support\Facades\Notification;

/**
 * Class AdminContactsController
 * @package App\Http\Controllers\Admin\System
 */
class AdminSlogansController extends Controller
{
    protected $sloganRepository;

    /**
     * AdminSlogansController constructor.
     * @param SloganRepository $sloganRepository
     */
    public function __construct(SloganRepository $sloganRepository)
    {
        $this->sloganRepository = $sloganRepository;
    }

    /**
     * Renvoi vers la page admin/system/slogans/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $slogans = $this->sloganRepository->getAllSlogans();

        return view('admin/system/slogans/index', compact('slogans'));
    }
}
