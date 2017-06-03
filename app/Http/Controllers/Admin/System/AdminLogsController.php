<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;

class AdminLogsController extends Controller
{
    protected $nbPerPage = 20;
    protected $logRepository;

    /**
     * AdminLogsController constructor.
     *
     * @param LogRepository $logRepository
     */
    public function __construct(LogRepository $logRepository)
    {
        $this->logRepository = $logRepository;
    }

    /**
     * Renvoi vers la page admin/system/logs/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $logs = $this->logRepository->getAllDistinctLogs();

        return view('admin/system/logs/index', compact('logs'));
    }

    /**
     * Affiche le contenu d'un log
     * Renvoi vers la page admin/system/logs/view
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view($id){
        $log = $this->logRepository->getLogByID($id);

        return view('admin/system/logs/view', compact('log'));
    }
}
