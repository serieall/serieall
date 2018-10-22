<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class AdminArticleController
 * @property CommentRepository commentRepository
 * @package App\Http\Controllers\Admin
 */
class AdminCommentController extends Controller
{
    protected $showRepository;

    /**
     * AdminCommentController constructor.
     *
     * @param ShowRepository $showRepository
     * @param CommentRepository $commentRepository
     */
    public function __construct(ShowRepository $showRepository,
                                CommentRepository $commentRepository) {
        $this->showRepository = $showRepository;
        $this->commentRepository = $commentRepository;
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
     * Liste des commentaires (séries / saisons / épisodes) à modérer pour cet utilisateur
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moderateComments($user_id) {
        $user = $this->userRepository->getUserByID($user_id);
        $shows = $this->showRepository->getAllShows();

        return view('admin.users.moderate_comments', compact('user', 'shows'));
    }

    /**
     * Liste des commentaires (articles) à modérer pour cet utilisateur
     *
     * @param $user_id
     */
    public function moderateCommentsArticles($user_id) {

    }

    /**
     * Retourne le commentaire demandé en JSON
     *
     * @param $user_id
     * @param $type
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getComment($user_id, $type, $id) {
        $comment = $this->commentRepository->getCommentByUserIDTypeTypeID($user_id, "App\\Models\\" . $type, $id);

        if(is_null($comment)) {
            return Response::json(View::make('admin.users.info_message')->render());
        }

        return Response::json(View::make('admin.users.avis', ['comment' => $comment])->render());
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