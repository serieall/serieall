<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

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
     * @return array
     * @internal param \App\Http\Requests\Request $request
     */
    public function rules()
    {
        return [
            'username' => 'required|max:255|unique:users,username,'. $this->get('id'),
//            TODO: Reactivate
//            'email' => 'required|email|max:255|unique:users,email,'. $this->get('id'),
            'role' => 'required|numeric',
            'password' => 'min:6|confirmed',
            'antispoiler' => 'boolean',
            'website' => 'max:255',
            'twitter' => 'max:255',
            'facebook' => 'max:255',
        ];
    }
}
