<?php

namespace App\Http\Requests;

use App\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'startpoint_id' => 'required|integer|exists:towns,id',
            'endpoint_id' => 'required|integer|exists:towns,id',
            'category_id' => 'required|integer|exists:categories,id',
            'date_time' => 'required|date|after:now',
            'description' => 'required|string|max:1024',
//            'price' => 'required|string|alpha_dash',
        ];
    }

    public function messages()
    {
        return [
            'date_time.required' => Helpers::validationMessage('Дата', 'required'),
            'date_time.date' => Helpers::validationMessage('Дата', 'date'),
            'date_time.after' => 'Поездки в прошлое запрещены!',
            'startpoint_id.required' => Helpers::validationMessage('Пункт отправления', 'required'),
            'startpoint_id.integer' => Helpers::validationMessage('id пункта отправления', 'integer'),
            'startpoint_id.exists' => 'Некорректно задан пункт отправления',
            'endpoint_id.required' => Helpers::validationMessage('Пункт назначения', 'required'),
            'endpoint_id.integer' => Helpers::validationMessage('id пункта назначения', 'integer'),
            'endpoint_id.exists' => 'Некорректно задан пункт назначения',
            'category_id.required' => Helpers::validationMessage('Категория', 'required'),
            'category_id.integer' => Helpers::validationMessage('Категория', 'integer'),
            'category_id.exists' => Helpers::validationMessage('Категория', 'exists'),
            'description.required' => Helpers::validationMessage('Описание', 'required'),
            'description.string' => Helpers::validationMessage('Описание', 'string'),
            'description.max' => Helpers::validationMessage('Описание', 'max', ['max' => 1024]),
//            'price.required' => Helpers::validationMessage('Стоимость', 'required'),
//            'price.string' => Helpers::validationMessage('Стоимость', 'string'),
        ];
    }
}
