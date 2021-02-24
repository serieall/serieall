<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class SloganUpdateRequest.
 */
class SloganUpdateRequest extends FormRequest
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
     *
     * @internal param \App\Http\Requests\Request $request
     */
    public function rules()
    {
        return [
            'message' => 'required',
            'source' => 'max:255',
            'url' => 'max:255',
        ];
    }
}
