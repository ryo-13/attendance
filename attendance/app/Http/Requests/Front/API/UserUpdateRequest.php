<?php

namespace App\Http\Requests\Front\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'old_password' => [
                'required', function($attribute, $value, $fail) {
                    if (!Hash::check($value, Auth::user()->password)) {
                        $fail('パスワードが違います');
                    }
                },
            ],
            'password' => 'nullable|alpha_dash|min:4|confirmed',
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '名前',
            'email' => 'メールアドレス',
            'old_password' => 'パスワード',
            'password' => 'パスワード',
        ];
    }
}
