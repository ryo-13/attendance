<?php

namespace App\Http\Requests\Front\API;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
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
            'date' => 'date_format:Y/m/d',
            'arrival' => 'date_format:H:i',
            'leave' => 'date_format:H:i',
        ];
    }
}
