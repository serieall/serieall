<?php

namespace App\Http\Transformers;

use App\Models\Show;
use League\Fractal\TransformerAbstract;

class ShowTransformer extends TransformerAbstract
{
    public function transform($show) : array
    {
        return [
            'id' => $show->id,
            'thetvdb_id' => $show->thetvdb_id,
            'url' => "/serie/" . $show->show_url,
            'name' => $show->name,
            'name_fr' => $show->name_fr,
            'synopsis' => $show->synopsis,
            'synopsis_fr' => $show->synopsis_fr,
            'format' => $show->format,
            'annee' => $show->annee,
            'encours' => $show->encours,
            'diffusion_us' => $show->diffusion_us,
            'diffusion_fr' => $show->diffusion_fr,
            'moyenne' => $show->moyenne,
            'moyenne_redac' => $show->moyenne_redac,
            'nbnotes' => $show->nbnotes,
            'taux_erectile' => $show->taux_erectile,
            'avis_rentree' => $show->avis_rentree,
        ];
    }
}