<?php

namespace App\Http\Requests\Front\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserConfirmPasswordRequest extends FormRequest
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
            'old_password' => [
                'required', function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('パスワードが違います');
                    }
                }
            ],
        ];
    }

    /**
     * @return void
     */
    public function attributes()
    {
        return [
            'old_passowrd' => 'パスワード',
        ];
    }
}
