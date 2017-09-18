<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;

use Route;

class CommentController extends Controller
{

    protected $commentRepository;
    protected $showRepository;

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     * @param ShowRepository $showRepository
     */
    public function __construct(CommentRepository $commentRepository,
                                ShowRepository $showRepository){
        $this->commentRepository = $commentRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Store a new comment
     *
     * @param CommentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentCreateRequest $request) {
        # Define variables by request
        $user_id = $request->user()->id;
        $object_id = $request->inputs['object_id'];
        $object = 'App\Models\\' . $request->inputs['object'];

        $inputs = $request->all();

        # Get Show
        $show = $this->showRepository->getShowByID($object_id);

        # Check id comment exist
        $comment_ref = $this->commentRepository->getCommentByUserIDTypeTypeID($user_id, $object, $object_id );

        # If not, we create it
        if(is_null($comment_ref)) {
            # Initialize
            $comment = new Comment();

            # Define fields
            $comment->message = $inputs['avis'];
            $comment->thumb = $inputs['thumb'];

            # Attach to user and save
            $comment->user()->associate($user_id);
            $comment->save();

            # Attach to show and save
            $show->comments()->save($comment);
        }
        else {
            # Redefine fields
            $comment_ref->message = $inputs['avis'];
            $comment_ref->thumb = $inputs['thumb'];

            # Attach to user and save
            $comment_ref->user()->associate($user_id);
            $comment_ref->save();

            # Attach to show and save
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
