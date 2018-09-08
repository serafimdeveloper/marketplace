<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Overide validate Login
     * @param Request $request
     */
//    protected function validateLogin(Request $request)
//    {
//        $this->validate($request, [
//            $this->username() => 'required',
//            'password' => 'required',
//            'g-recaptcha-response' => 'required|recaptcha',
//        ]);
//    }

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->redirectTo = (Session::has('old')) ? redirect()->intended() : 'accont';
        $this->middleware('guest', ['except' => 'logout']);
    }

}
