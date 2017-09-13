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

        $comment_ref = Comment::where('commentable_id', '=', $inputs['show_id'])
            ->where('user_id', '=', $user_id)
            ->where('commentable_type', '=', 'App\Models\Show')
            ->first();

        if(is_null($comment_ref)) {
            $comment = new Comment();

            $comment->message = $inputs['avis'];
            $comment->thumb = $inputs['thumb'];

            $comment->user()->associate($user_id);
            $comment->save();

            $show = $this->showRepository->getShowByID($inputs['show_id']);
            $show->comments()->save($comment);
        }
        else {
            $comment_ref->message = $inputs['avis'];
            $comment_ref->thumb = $inputs['thumb'];

            $comment_ref->user()->associate($user_id);
            $comment_ref->save();

            $show = $this->showRepository->getShowByID($inputs['show_id']);
            $show->comments()->save($comment_ref);
        }

        return response()->json();
    }

    /**
     * Redirection
     * @return \Illuminate\Http\Response
     * @internal param $show_id
     */
    public function redirect()
    {
        return redirect()->back();
    }
}
