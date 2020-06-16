<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\User;

/**
 * Class UserUpdateRequest
 * @package App\Http\Requests
 */
class UserUpdateRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'max:255',
                Rule::unique(User::class)->ignore($this->user),
            ],
            'password' => 'nullable|alpha_dash|confirmed|min:4',
        ];
    }
}

