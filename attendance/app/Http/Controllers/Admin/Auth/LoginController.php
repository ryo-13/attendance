<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::ADMIN_HOME;
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return void
     */
    public function loggedOut(Request $request)
    {
        return redirect(route('admin.login'));
    }
}