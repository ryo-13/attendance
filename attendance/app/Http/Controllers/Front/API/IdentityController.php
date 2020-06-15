<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\API\UserConfirmPasswordRequest;
use App\Http\Requests\Front\API\UserUpdateRequest;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    /**
     * ユーザー情報をjsonで返す
     *
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request)
    {
        return $request->user();
    }

    /**
     * パスワード確認
     *
     * @param UserConfirmPasswordRequest $request
     * @return void
     */
    public function confirmPassword(UserConfirmPasswordRequest $request)
    {
        //Todo 特になし
    }

    /**
     * ユーザー情報を更新、jsonを返す
     *
     * @param UserUpdateRequest $request
     * @return mixed
     */
    public function update(UserUpdateRequest $request)
    {
        $request->user()->fill($request->all())->save();
        return $request->user();
    }
}
