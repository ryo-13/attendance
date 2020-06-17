<?php

namespace App\Http\Requests\Front\API;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeStoreRequest extends FormRequest
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
            'date' => 'required|date_format:Y-m-d',
            'overtime' => 'required|date_format:H:i|max:10:00',
            'reason' => 'required|string|max:255',
        ];
    }

    /**
     * overtime(残業時間)条件指定
     *
     * @param \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function($validator) {
            if (
                !($this->overtime > '00:00'
                &&
                $this->overtime <= '10:00')
            ) {
                $validator->errors()->add('field', '残業時間を10時間以内にしてください');
            }
        });
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'date' => '勤務日',
            'overtime' => '残業時間',
            'reason' => '申請理由',
        ];
    }
}
