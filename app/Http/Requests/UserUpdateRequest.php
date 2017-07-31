<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'username' => 'required|max:255|exists:users',
            'email' => 'required|email|max:255|exists:users',
            'role' => 'required|numeric',
            'password' => 'min:6|confirmed',
            'antispoiler' => 'required|boolean',
            'website' => 'max:255',
            'twitter' => 'max:255',
            'facebook' => 'max:255',
        ];
    }
}
