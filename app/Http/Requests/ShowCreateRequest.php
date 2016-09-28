<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ShowCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'thetvdb_id' => 'required|numeric',
            'creators' => ['regex:/^[A-Za-z0-9-éèàù ]{1,255}?(,[A-Za-z0-9-éèàù ]{1,255})*$/'],
            'nationalities' => ['regex:/^[A-Za-z0-9-éèàù ]{1,255}?(,[A-Za-z0-9-éèàù ]{1,255})*$/'],
            'chaine_fr' => ['regex:/^[A-Za-z0-9-éèàù ]{1,255}?(,[A-Za-z0-9-éèàù ]{1,255})*$/'],
            'diffusion_fr' => 'date',
            'taux_erectile' => 'numeric|between:1,100',
            'avis_rentree' => 'text'
        ];
    }
}
