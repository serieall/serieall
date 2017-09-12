<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;

use App\Models\Comment;
use App\Repositories\ShowRepository;

class CommentController extends Controller
{

    protected $showRepository;

    /**
     * CommentController constructor.
     * @param ShowRepository $showRepository
     */
    public function __construct(ShowRepository $showRepository){
        $this->showRepository = $showRepository;
    }

    public function store(CommentCreateRequest $request) {
        $user_id = $request->user()->id;
        $inputs = $request->all();

        $comment = new Comment();

        $comment->message = $inputs['avis'];
        $comment->thumb = $inputs['thumb'];
        if(isset($inputs['spoiler'])){
            $comment->spoiler = $inputs['spoiler'];
        }

        $comment->user()->associate($user_id);
        $comment->save();

        $show = $this->showRepository->getShowByID($inputs['show_id']);
        $show->comments()->save($comment);
    }
}
