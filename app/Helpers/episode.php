<?php

declare(strict_types=1);

use App\Models\Show;

function linkAndCreateEpisodesToShow(Show $show) {
    # Get the first page of episodes
    apiTvdbGetEpisodesForShow("en", $show->thetvdb_id, 1);

}