<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Repositories\Admin\AdminRepository;
use App\Http\Controllers\Controller;

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
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'home';

        return view('admin/index', compact('navActive'));
    }



}
