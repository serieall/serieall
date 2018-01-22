<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * Class UserStoreRequest
 * @package App\Http\Requests
 */
class UserStoreRequest extends FormRequest
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
            'username' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'role' => 'required|numeric',
            'password' => 'required|min:6|confirmed',
            'antispoiler' => 'boolean',
            'website' => 'max:255',
            'twitter' => 'max:255',
            'facebook' => 'max:255'];
    }
}
