<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\AdminRepository;
use App\Http\Controllers\Controller;
use App\Repositories\LogRepository;

class AdminController extends Controller
{
    protected $nbPerPage = 20;
    protected $adminRepository;
    protected $logRepository;

    public function __construct(AdminRepository $adminRepository, LogRepository $logRepository)
    {
        $this->adminRepository = $adminRepository;
        $this->logRepository = $logRepository;
    }

    public function index(){
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'home';
        $logs = $this->logRepository->getDistinctLogs();

        return view('admin/index', compact('navActive', 'logs'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function viewLog($id){
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'home';

        $log = $this->logRepository->getLogsByID($id);

        return view('admin/log', compact('navActive', 'log'));
    }



}
