<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\EpisodeUpdateRequest;
use App\Jobs\EpisodeDelete;
use App\Jobs\EpisodeUpdate;
use App\Repositories\EpisodeRepository;

use Illuminate\Support\Facades\Auth;

class AdminEpisodeController extends Controller
{
    protected $episodeRepository;

    /**
     * AdminArtistController constructor.
     *
     * @param EpisodeRepository $episodeRepository
     * @internal param SeasonRepository $seasonRepository
     * @internal param ShowRepository $showRepository
     * @internal param ArtistRepository $artistRepository
     */
    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->episodeRepository = $episodeRepository;
    }

    /**
     * Montre le formulaire d'édition d'un épisode
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $episode=$this->episodeRepository->getEpisodeWithSeasonShowByID($id);
        $directors = formatRequestInVariableNoSpace($episode->directors);
        $writers = formatRequestInVariableNoSpace($episode->writers);
        $guests = formatRequestInVariableNoSpace($episode->guests);

        return view('admin.episodes.edit', compact('episode', 'directors', 'writers', 'guests'));
    }

    /**
     * Met à jour une série
     *
     * @param EpisodeUpdateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(EpisodeUpdateRequest $request)
    {
        $inputs = array_merge($request->all(), ['user_id' => $request->user()->id]);

        dispatch(new EpisodeUpdate($inputs));

        return redirect()->route('admin.seasons.show', $inputs['show_id'])
            ->with('status_header', 'Modification')
            ->with('status', 'La demande de modification a été envoyée au serveur. Il la traitera dès que possible.');
    }

    /**
     * Suppression d'un épisode
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @internal param $show_id
     * @internal param $season_id
     * @internal param $id
     */
    public function destroy($id)
    {
        $userID = Auth::user()->id;

        dispatch(new EpisodeDelete($id, $userID));

        return redirect()->back()
            ->with('status_header', 'Suppression de l\'épisode')
            ->with('status', 'La demande de suppression a été envoyée au serveur. Il la traitera dès que possible.');
    }

}
