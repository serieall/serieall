<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;

use App\Repositories\EpisodeRepository;
use App\Repositories\SeasonRepository;
use App\Repositories\ShowRepository;

use App\Http\Requests\RateRequest;

use App\Models\Episode;
use App\Models\Episode_user;
use App\Models\Season;

class EpisodeController extends Controller
{
    protected $episodeRepository;
    protected $seasonRepository;
    protected $showRepository;

    /**
     * EpisodeController constructor.
     * @param EpisodeRepository $episodeRepository
     * @param SeasonRepository $seasonRepository
     * @param ShowRepository $showRepository
     */
    public function __construct(EpisodeRepository $episodeRepository,
                                SeasonRepository $seasonRepository,
                                ShowRepository $showRepository)
    {
        $this->episodeRepository = $episodeRepository;
        $this->seasonRepository = $seasonRepository;
        $this->showRepository = $showRepository;
    }

    public function getShowEpisodes($episodeID)
    {
        $client = new Client(['base_uri' => env('APP_URL')]);
        $data = json_decode($client->request('GET', '/api/rates/episode/' . $episodeID)->getBody());
        dd($data->episode->users);
        return view('shows.episodes', compact('data'));
    }



    /**
     * Notation d'un épisode
     * Mise à jour de le moyenne des épisodes/saisons/séries
     * Mise à jour du nombre de notes épisodes/saisons/séries
     *
     * @param RateRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function rateEpisode(RateRequest $request)
    {
        // Définition des variables
        $user_id = $request->user()->id;

        // La note existe-elle ?
        $rate_ref = Episode_user::where('episode_id', '=', $request->episode_id)
            ->where('user_id', '=', $user_id)
            ->first();

        // Objets épisode, saison et séries
        $episode_ref = $this->episodeRepository->getEpisodeByID($request->episode_id);
        $season_ref = $this->seasonRepository->getSeasonByID($episode_ref->season_id);
        $show_ref = $this->showRepository->getShowByID($season_ref->show_id);

        // Si la note n'exite pas
        if(is_null($rate_ref)) {
            // On l'ajoute
            $episode_ref->users()->attach($user_id, ['rate' => $request->note]);

            # On incrémente tous les nombres d'épisodes
            $episode_ref->nbnotes += 1;
            $season_ref->nbnotes += 1;
            $show_ref->nbnotes += 1;
        }
        else {
            // On la met simplement à jour
            $episode_ref->users()->updateExistingPivot($user_id, ['rate' => $request->note]);
        }

        // On calcule sa moyenne et on la sauvegarde dans l'objet
        $mean_episode = Episode_user::where('episode_id', '=', $episode_ref->id)
            ->avg('rate');
        $episode_ref->moyenne = $mean_episode;
        $episode_ref->save();

        // On calcule la moyenne de la saison et on la sauvegarde dans l'objet
        $mean_season = Episode::where('season_id', '=', $season_ref->id)
            ->where('moyenne', '>', 0)
            ->avg('moyenne');

        $season_ref->moyenne = $mean_season;
        $season_ref->save();

        // On calcule la moyenne de la série et on la sauvegarde dans l'objet
        $mean_show = Season::where('show_id', '=', $show_ref->id)
            ->where('moyenne', '>', 0)
            ->avg('moyenne');

        $show_ref->moyenne = $mean_show;
        $show_ref->save();

        return redirect()->back();
    }
}
