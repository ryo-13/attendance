<?php

namespace App\Http\Requests\Front\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AttendanceArrivalUpdateRequest extends FormRequest
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
            'arrival' => 'date_format:H:i',
        ];
    }

    public function messages()
    {
        return [
            'arrival.date_format:H:i' => '時間形式で入力してください。',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $response['data'] = [];
        $response['status'] = 'NG';
        $response['summary'] = 'Failed validation.';
        $response['errors']  = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, 422)
        );
    }
}
