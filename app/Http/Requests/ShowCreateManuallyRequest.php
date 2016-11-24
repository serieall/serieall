<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowCreateManuallyRequest extends FormRequest
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
            'thetvdb_id' => 'required|numeric|unique:shows',
            'creators' => ['regex:/^[A-Za-z0-9-éèàùç%+ ]{1,255}?(,[A-Za-z0-9-éèàùç%+ ]{1,255})*$/'],
            'nationalities' => ['regex:/^[A-Za-z0-9-éèàùç%+ ]{1,255}?(,[A-Za-z0-9-éèàùç%+ ]{1,255})*$/'],
            'chaine_fr' => ['regex:/^[A-Za-z0-9-éèàùç%+ ]{1,255}?(,[A-Za-z0-9-éèàùç%+ ]{1,255})*$/'],
            'diffusion_fr' => 'date',
            'taux_erectile' => 'numeric|between:1,100',

        ];
    }
}
