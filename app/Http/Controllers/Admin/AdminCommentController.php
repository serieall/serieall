<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\CommentUpdateRequest;
use App\Repositories\CommentRepository;
use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class AdminArticleController
 * @property CommentRepository commentRepository
 * @property EpisodeRepository episodeRepository
 * @property SeasonRepository seasonRepository
 * @property ShowRepository showRepository
 * @package App\Http\Controllers\Admin
 */
class AdminCommentController extends Controller
{

    /**
     * AdminCommentController constructor.
     *
     * @param ShowRepository $showRepository
     * @param CommentRepository $commentRepository
     * @param EpisodeRepository $episodeRepository
     * @param SeasonRepository $seasonRepository
     */
    public function __construct(ShowRepository $showRepository,
                                CommentRepository $commentRepository,
                                EpisodeRepository $episodeRepository,
                                SeasonRepository $seasonRepository) {

        $this->showRepository = $showRepository;
        $this->commentRepository = $commentRepository;
        $this->episodeRepository = $episodeRepository;
        $this->seasonRepository = $seasonRepository;
    }

    /**
     * Print vue admin/comments/index
     *
     */
    public function index()
    {
        $shows = $this->showRepository->getAllShows();

        return view('admin.comments.index', compact('shows'));
    }

    /**
     * Retourne la liste des commentaires demandés en JSON
     *
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComments($type, $id) {
        $comments = $this->commentRepository->getAllCommentsByTypeTypeID("App\\Models\\" . $type, $id);

        if(count($comments) < 1) {
            return Response::json(View::make('admin.comments.info_message')->render());
        }

        return Response::json(View::make('admin.comments.list_avis', ['comments' => $comments])->render());
    }

    /**
     * Print vue admin/comments/edit
     * @param $comment_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($comment_id)
    {
        $shows = $this->showRepository->getAllShows();
        $comment = $this->commentRepository->getCommentByID($comment_id);

        return view('admin.comments.edit', compact('shows', 'comment'));
    }

    /**
     * Update a comment
     *
     * @param CommentUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CommentUpdateRequest $request) {
        $inputs = $request->all();
        $comment = $this->commentRepository->getCommentByID($inputs['id']);

        if(isset($inputs['thumb'])) {
            $comment->thumb = $inputs['thumb'];
        }

        $comment->message = $inputs['avis'];

        if(!empty($inputs['show'])) {
            // Si episode est renseigné, on lie à l'épisode
            if(!empty($inputs['episode'])) {
                $episode = $this->episodeRepository->getEpisodeByIDWithSeasonIDAndShowID($inputs['episode']);

                $episode->comments()->save($comment);
            }
            // Si season est renseigné, on lie à la saison
            elseif(empty($inputs['season'])) {
                $show = $this->showRepository->getByID($inputs['show']);
                $show->comments()->save($comment);
            }
            // Sinon, on lie à la série
            else {
                $season = $this->seasonRepository->getSeasonWithShowByID($inputs['season']);
                $season->comments()->save($comment);
            }
        }
        $comment->save();

        return redirect()->back()
            ->with('status_header', 'Modération d\'un commentaire')
            ->with('status', 'Le commentaire a été modéré');
    }

    /**
     * @param $comment_id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($comment_id) {
        $comment = $this->commentRepository->getCommentByID($comment_id);

        foreach($comment->children as $child) {
            $child->delete();
        }

        $comment->delete();

        return redirect()->back()
            ->with('status_header', 'Suppression de l\'avis')
            ->with('status', 'L\'avis a été supprimé.');
    }


}