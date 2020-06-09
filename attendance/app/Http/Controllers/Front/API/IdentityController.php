<?php

namespace App\Http\Controllers\Front\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\API\UserUpdateRequest;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user();
    }

    /**
     * Undocumented function
     *
     * @param UserUpdateRequest $request
     * @return void
     */
    public function update(UserUpdateRequest $request)
    {
        $request->user()->fill($request->all())->save();
        return $request->user();
    }
}
