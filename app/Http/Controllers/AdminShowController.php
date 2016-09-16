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
    protected $navActive = 'show';

    public function __construct(AdminShowRepository $adminShowRepository, $navActive)
    {
        $this->adminShowRepository = $adminShowRepository;
        $this->navActive = $navActive;
    }

    public function indexSeries(){
        $shows = $this->adminShowRepository->getShowByName($this->nbPerPage);
        $links = $shows->render();

        return view('admin/indexSeries', compact('shows', 'links'));
    }
}
