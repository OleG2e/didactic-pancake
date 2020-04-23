<?php

namespace App\Http\Requests;

use App\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class ReplyRequest extends FormRequest
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
            'attachment' => 'nullable|string',
            'description' => 'required|string|max:1024',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => Helpers::validationMessage('Ответ', 'required'),
            'description.string' => Helpers::validationMessage('Ответ', 'string'),
            'description.max' => Helpers::validationMessage('Ответ', 'max', ['length' => 1024]),
        ];
    }
}
