<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Jobs\EpisodeDelete;
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
