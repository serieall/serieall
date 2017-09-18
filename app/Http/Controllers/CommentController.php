<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;

class CommentController extends Controller
{

    protected $commentRepository;
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     */
    public function __construct(CommentRepository $commentRepository,
                                ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository){
        $this->commentRepository = $commentRepository;
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * Store a new comment
     *
     * @param CommentCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CommentCreateRequest $request) {
        # Define variables by request
        $inputs = $request->all();
        $user_id = $request->user()->id;
        $object_id = $inputs['object_id'];
        $object = $inputs['object'];
        $objectFQ = 'App\Models\\' . $object;

        # Get Object
        switch ($object){
            case 'Show':
                $object = $this->showRepository->getShowByID($object_id);
                break;
            case 'Season':
                $object = $this->seasonRepository->getSeasonByID($object_id);
                break;
            case 'Episode':
                $object = $this->episodeRepository->getEpisodeByID($object_id);
                break;
            default:
                return response()->json();
                break;
        }

        # Check id comment exist
        $comment_ref = $this->commentRepository->getCommentByUserIDTypeTypeID($user_id, $objectFQ, $object_id );

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
            $object->comments()->save($comment);
        }
        else {
            # Redefine fields
            $comment_ref->message = $inputs['avis'];
            $comment_ref->thumb = $inputs['thumb'];

            # Attach to user and save
            $comment_ref->user()->associate($user_id);
            $comment_ref->save();

            # Attach to show and save
            $object->comments()->save($comment_ref);
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
