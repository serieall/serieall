<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;

class AdminSystemController extends Controller
{
    /**
     * AdminSystemController constructor.
     */
    public function __construct()
    {

    }

    /**
     * Renvoi vers la page admin/system/index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('admin/system/index');
    }
}
