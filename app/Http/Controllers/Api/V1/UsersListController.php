<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Marcelgwerder\ApiHandler\Facades\ApiHandler;
use App\Http\Transformers\UsersListTransformer;


class UsersListController extends Controller
{
    use Helpers;
    protected $users;

    public function __construct(User $users){
        $this->users = $users;
    }

    /**
     * @return \Dingo\Api\Http\Response
     */
    public function index() : \Dingo\Api\Http\Response
    {
        $users = $this->users
            ->select('id', 'username')
            ->orderBy('username');

        $users = ApiHandler::parseMultiple($users, array('username'))->getResult();

        return $this->response->collection($users, new UsersListTransformer());
    }
}
