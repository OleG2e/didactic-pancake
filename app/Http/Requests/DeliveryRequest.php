<?php

namespace App\Http\Requests;

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
            'startpoint_id' => 'required|integer',
            'endpoint_id' => 'required|integer',
            'category_id' => 'required|integer',
            'timestamp' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|string',
        ];
    }
}
