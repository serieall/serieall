<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AdminRepository;

use App\Http\Requests;

class AdminController extends Controller
{
    protected $nbPerPage = 20;
    protected $adminRepository;

    public function __construct(AdminRepository $adminRepository)
    {
        $this->adminRepository = $adminRepository;
    }

    public function index(){
        return view('admin/index');
    }

    public function indexSeries(){
        $nav_active = 'show';

        $shows = $this->adminRepository->getShowByName($this->nbPerPage);
        $links = $shows->render();

        return view('admin/indexSeries', compact('shows', 'links', 'nav_active'));
    }
}
