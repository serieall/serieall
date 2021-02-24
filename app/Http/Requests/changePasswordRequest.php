<?php

declare(strict_types=1);

namespace App\Http\Requests;

/**
 * Class changePasswordRequest.
 *
 * @property mixed new_password
 * @property mixed password
 */
class changePasswordRequest extends Request
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
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed|different:password',
        ];
    }
}
