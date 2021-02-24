<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ArticleCreateRequest.
 */
class ArticleCreateRequest extends FormRequest
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
     * Configure the validator instance.
     *
     * @param \Illuminate\Validation\Validator $validator
     *
     * @return void
     */
    protected function withValidator($validator)
    {
        $validator->sometimes('shows', 'required', function ($input) {
            return 0 == $input->one;
        });
        $validator->sometimes('image', 'required|image|max:2000', function ($input) {
            return 0 == $input->one;
        });
        $validator->sometimes('image', 'required|image|max:2000', function ($input) {
            return '' == $input->show;
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => 'required|numeric',
            'one' => 'required|boolean',
            'name' => 'required|string',
            'intro' => 'required',
            'article' => 'required',
            'users' => 'required',
        ];
    }
}
