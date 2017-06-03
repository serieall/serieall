<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;

class AdminSystemController extends Controller
{
    public function __construct()
    {

    }

    public function index() {
        return view('admin/system/index');
    }
}
