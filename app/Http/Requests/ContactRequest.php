<?php
declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class ContactRequest
 * @package App\Http\Requests
 */
class ContactRequest extends Request
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
            'name' => 'required|max:255',
            'email' => 'required|email',
            'objet' => 'required|between:10,100'
        ];
    }
}
