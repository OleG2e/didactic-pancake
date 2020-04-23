<?php

namespace App\Http\Requests;

use App\Helpers;
use Illuminate\Foundation\Http\FormRequest;

class TripRequest extends FormRequest
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
            'date' => "required|date|after:now",
            'description' => 'string|nullable|max:1024',
            'endpoint_id' => 'required|integer|exists:towns,id',
            'passengers_count' => 'required|integer',
            'price' => 'required|string|alpha_dash',
            'startpoint_id' => 'required|integer|exists:towns,id',
            'time' => 'required|date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'date.required' => Helpers::validationMessage('Дата', 'required'),
            'date.date' => Helpers::validationMessage('Дата', 'date'),
            'date.after' => 'Поездки в прошлое запрещены!',
            'startpoint_id.required' => Helpers::validationMessage('Пункт отправления', 'required'),
            'startpoint_id.integer' => Helpers::validationMessage('id пункта отправления', 'integer'),
            'startpoint_id.exists' => 'Некорректно задан пункт отправления',
            'endpoint_id.required' => Helpers::validationMessage('Пункт назначения', 'required'),
            'endpoint_id.integer' => Helpers::validationMessage('id пункта назначения', 'integer'),
            'endpoint_id.exists' => 'Некорректно задан пункт назначения',
            'passengers_count.required' => Helpers::validationMessage('Количество пассажиров', 'required'),
            'passengers_count.integer' => Helpers::validationMessage('Количество пассажиров', 'integer'),
            'description.string' => Helpers::validationMessage('Описание', 'string'),
            'price.required' => Helpers::validationMessage('Стоимость', 'required'),
            'price.string' => Helpers::validationMessage('Стоимость', 'string'),
        ];
    }
}
