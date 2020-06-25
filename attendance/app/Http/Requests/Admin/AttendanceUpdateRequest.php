<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UserUpdateRequest
 * @package App\Http\Requests
 */
class AttendanceUpdateRequest extends FormRequest
{

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'arrival' => 'date_format:H:i',
            'leave' => 'date_format:H:i',
        ];
    }
}

