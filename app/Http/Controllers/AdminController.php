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
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $nav_active = '';

        return view('admin/index', compact('nav_active'));
    }



}
