<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreProductCategory
 * @package App\Http\Requests
 */
class StoreUser extends FormRequest
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
            'email' => 'required|string|max:255|unique:App\Models\User',
            'password' => 'required|alpha_dash|confirmed|min:4',
        ];
    }
}

