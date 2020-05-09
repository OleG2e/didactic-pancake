<?php

namespace App\Http\Requests;

use App\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
            'title' => 'required|string|max:20',
            'description' => 'required|string|max:1024',
            'coords' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'category_id.required' => Helpers::validationMessage('Категория', 'required'),
            'category_id.integer' => Helpers::validationMessage('id категории', 'integer'),
            'category_id.exists' => Helpers::validationMessage('Категория', 'exists'),
            'title.required' => Helpers::validationMessage('Заголовок', 'required'),
            'title.string' => Helpers::validationMessage('Заголовок', 'string'),
            'title.max' => Helpers::validationMessage('Заголовок', 'max', ['length' => 20]),
            'description.required' => Helpers::validationMessage('Текст', 'required'),
            'description.string' => Helpers::validationMessage('Текст', 'string'),
            'description.max' => Helpers::validationMessage('Текст', 'max', ['length' => 1024]),
        ];
    }
}
