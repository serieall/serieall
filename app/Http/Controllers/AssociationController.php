<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

/**
 * Class ArticleController.
 */
class AssociationController extends Controller
{
    /**
     * Return the view association.index.
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('association.index');
    }
}
