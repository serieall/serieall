<?php


namespace App\Traits;


trait FormatShowHeaderTrait
{

    /**
     * Format data for displaying show header.
     * @param $show
     * @return array
     */
    protected function formatForShowHeader($show){
        $articles = [];

        $nbcomments = $this->commentRepository->getCommentCountByTypeForShow($show->id);

        $showPositiveComments = $nbcomments->where('thumb', '=', '1')->first();
        $showNeutralComments = $nbcomments->where('thumb', '=', '2')->first();
        $showNegativeComments = $nbcomments->where('thumb', '=', '3')->first();

        // On récupère les saisons, genres, nationalités et chaines

        $genres = formatRequestInVariable($show->genres);
        $nationalities = formatRequestInVariable($show->nationalities);
        $channels = formatRequestInVariable($show->channels);

        // On récupère la note de la série, et on calcule la position sur le cercle
        $noteCircle = noteToCircle($show->moyenne);

        // Détection du résumé à afficher (fr ou en)
        if(empty($show->synopsis_fr)) {
            $synopsis = $show->synopsis;
        }
        else {
            $synopsis = $show->synopsis_fr;
        }

        // Faut-il couper le résumé ? */
        $numberCharaMaxResume = config('param.nombreCaracResume');
        if(strlen($synopsis) <= $numberCharaMaxResume) {
            $showSynopsis = $synopsis;
            $fullSynopsis = false;
        }
        else {
            $showSynopsis = cutResume($synopsis);
            $fullSynopsis = true;
        }

        return compact('show', 'genres', 'nationalities', 'channels', 'noteCircle', 'synopsis', 'showSynopsis', 'fullSynopsis', 'showPositiveComments', 'showNeutralComments', 'showNegativeComments', 'articles');

    }
}