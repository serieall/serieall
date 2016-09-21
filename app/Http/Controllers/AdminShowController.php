<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\AdminShowRepository;

use App\Http\Requests;

class AdminShowController extends Controller
{
    protected $nbPerPage = 20;
    protected $adminShowRepository;

    // Variable qui détecte dans quelle partie de l'admin on se trouve


    public function __construct(AdminShowRepository $adminShowRepository)
    {
        $this->adminShowRepository = $adminShowRepository;
    }

    public function indexShows(){
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';
        $shows = $this->adminShowRepository->getShowByName();

        return view('admin/shows/indexShows', compact('shows', 'navActive'));
    }

    public function addShow(){
        #Variable qui détecte dans quelle partie de l'admin on se trouve
        $navActive = 'show';

        return view('admin/shows/addShow', compact('navActive'));
    }
}
