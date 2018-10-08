<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Http\Requests\SloganCreateRequest;
use App\Http\Requests\SloganUpdateRequest;
use App\Jobs\SloganStore;
use App\Jobs\SloganUpdate;

use App\Repositories\SloganRepository;
use Illuminate\Http\RedirectResponse;

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
    public function index() {
        $slogans = $this->sloganRepository->getAllSlogans();

        return view('admin/system/slogans/index', compact('slogans'));
    }

    /**
     * Renvoi vers la page admin/system/slogans/create
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        return view('admin.system.slogans.create');
    }

    /**
     * Stocke les nouveaux slogans.
     *
     * @param SloganCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SloganCreateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->dispatch(new SloganStore($inputs));

        return response()->json();
    }

    /**
     * Renvoi vers la page admin/system/slogans/edit
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id) {
        $slogan = $this->sloganRepository->getSloganByID($id);

        return view('admin/system/slogans/edit', compact('slogan'));
    }

    /** Met à jour un slogan
     * @param SloganUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SloganUpdateRequest $request) {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        dispatch(new SloganUpdate($inputs));

        return redirect()->route('admin.slogans.index')
            ->with('status_header', 'Modification d\'un slogan')
            ->with('status', 'La demande de modification a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Redirection JSON
     *
     * @return RedirectResponse
     */
    public function redirect() {
        return redirect()->route('admin.slogans.index')
            ->with('status_header', 'Slogans en cours d\'ajout')
            ->with('status', 'La demande de créations de slogans a été effectuée. Le serveur la traitera dès que possible.');
    }
}
