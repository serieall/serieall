<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentCreateRequest;

use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\RateRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;

class CommentController extends Controller
{

    protected $commentRepository;
    protected $showRepository;
    protected $seasonRepository;
    protected $episodeRepository;
    protected $rateRepository;

    /**
     * CommentController constructor.
     * @param CommentRepository $commentRepository
     * @param ShowRepository $showRepository
     * @param SeasonRepository $seasonRepository
     * @param EpisodeRepository $episodeRepository
     * @param RateRepository $rateRepository
     */
    public function __construct(CommentRepository $commentRepository,
                                ShowRepository $showRepository,
                                SeasonRepository $seasonRepository,
                                EpisodeRepository $episodeRepository,
                                RateRepository $rateRepository){
        $this->commentRepository = $commentRepository;
        $this->showRepository = $showRepository;
        $this->seasonRepository = $seasonRepository;
        $this->episodeRepository = $episodeRepository;
        $this->rateRepository = $rateRepository;
    }

    public function fiche($show_url, $season_name = null, $episode_numero = null, $episode_id = null) {
        # Get ID User if user authenticated
        $user_id = getIDIfAuth();

        $showInfo = $this->showRepository->getInfoShowFiche($show_url);

        if(!is_null($season_name)) {
            $seasonInfo = $this->seasonRepository->getSeasonEpisodesBySeasonNameAndShowID($showInfo['show']->id, $season_name);
            if(!is_null($episode_numero)) {
                if(!is_null($episode_id)) {
                    $episodeInfo = $this->episodeRepository->getEpisodeByID($episode_id);
                    $object = compileObjectInfos('Episode', $episodeInfo->id);
                    $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);
                }
                else{
                    $episodeInfo = $this->episodeRepository->getEpisodeByEpisodeNumeroAndSeasonID($seasonInfo->id, $episode_numero);

                    # Compile Object informations
                    $object = compileObjectInfos('Episode', $episodeInfo->id);

                    # Get Comments
                    $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);
                }
            }
            else {
                # Compile Object informations
                $object = compileObjectInfos('Season', $seasonInfo->id);

                # Get Comments
                $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);
            }
        }
        else {
            # Compile Object informations
            $object = compileObjectInfos('Show', $showInfo['show']->id);

            # Get Comments
            $comments = $this->commentRepository->getCommentsForFiche($user_id, $object['fq_model'], $object['id']);
        }

        return view('comments.fiche', compact('showInfo', 'seasonInfo', 'episodeInfo', 'object', 'comments'));
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

        if(isset($inputs['episode_id']) && isset($inputs['note']))
        {
            $this->rateRepository->RateEpisode($user_id, $inputs['episode_id'], $inputs['note']);
        }
            return response()->json();
    }
}
