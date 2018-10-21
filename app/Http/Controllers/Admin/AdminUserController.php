<?php
declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\UserStore;
use App\Jobs\UserUpdate;
use App\Repositories\CommentRepository;
use App\Repositories\ShowRepository;
use Illuminate\Support\Facades\Auth;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

/**
 * Class AdminUserController
 * @package App\Http\Controllers\Admin
 */
class AdminUserController extends Controller
{
    protected $userRepository;
    protected $commentRepository;
    protected $showRepository;

    /**
     * AdminUserController constructor.
     *
     * @param UserRepository $userRepository
     * @param CommentRepository $commentRepository
     * @param ShowRepository $showRepository
     * @internal param SeasonRepository $seasonRepository
     * @internal param ShowRepository $showRepository
     * @internal param ArtistRepository $artistRepository
     */
    public function __construct(UserRepository $userRepository, CommentRepository $commentRepository, ShowRepository $showRepository)
    {
        $this->userRepository = $userRepository;
        $this->commentRepository = $commentRepository;
        $this->showRepository = $showRepository;
    }

    /**
     * Affiche l'index de l'administation des utilisateurs
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // On récupère la liste des utilisateurs
        $users = $this->userRepository->getAllUsers();

        // On retourne la vue
        return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche le formulaire de création d'utilisateur
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Ajoute un nouvel utilisateur
     *
     * @param UserStoreRequest $request
     * @return string
     */
    public function store(UserStoreRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        $this->dispatch(new UserStore($inputs));

        return redirect()->route('admin.users.index')
            ->with('status_header', 'Ajout d\'un utilisateur')
            ->with('status', 'La demande d\'ajout a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Affiche le formulaire d'édition de l'utilisateur
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function edit($id)
    {
        $user = $this->userRepository->getUserByID($id);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Met à jour un utilisateur
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $id
     */
    public function update(UserUpdateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        dispatch(new UserUpdate($inputs));

        return redirect()->route('admin.users.index')
            ->with('status_header', 'Modification d\'un utilisateur')
            ->with('status', 'La demande de modification a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Bannir ou débannir un utilisateur
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function ban($id)
    {
        $user = $this->userRepository->getUserByID($id);
        $userID = Auth::user()->id;

        $logID = initJob($userID, 'Ban', 'User', $user->id);

        if($user->suspended == 1)
        {
            $logMessage = 'Déban de l\'utilisateur ' . $user->username;
            saveLogMessage($logID, $logMessage);
            $user->suspended = 0;
        }
        else
        {
            $logMessage = 'Ban de l\'utilisateur ' . $user->username;
            saveLogMessage($logID, $logMessage);
            $user->suspended = 1;
        }

        $user->save();
        endJob($logID);

        return view('admin.users.edit', compact('user'));
    }

    /**
     * Liste des commentaires (séries / saisons / épisodes) à modérer pour cet utilisateur
     *
     * @param $user_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function moderateComments($user_id) {
        $default_message = view::make('admin.users.info_message')->render();
        $user = $this->userRepository->getUserByID($user_id);
        $shows = $this->showRepository->getAllShows();

        return view('admin.users.moderate_comments', compact('user', 'shows', 'default_message'));
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
    public function destroyComment($comment_id) {
        $comment = $this->commentRepository->getCommentByID($comment_id);

        $comment->delete();

        return redirect()->back()
            ->with('status_header', 'Suppression de l\'avis')
            ->with('status', 'L\'avis a été supprimé.');
    }

}
