<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->redirectTo = (Session::has('oldUrl')) ? redirect()->intended() : 'account';
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:30',
            'last_name' =>'required|max:255',
            'email_register' => 'required|email|max:255|unique:users,email|confirmed',
            'password_register' => 'required|min:6|max:20|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user =  User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email_register'],
            'password' => bcrypt($data['password_register']),
            'confirm_token'=> str_random(20),
            'remember_token'=>str_random(20),
            'active'=> 0
        ]);

        $data = ['email' => $user->email, 'user' => $user];
        send_mail('emails.confirmation_account',$data,'Confirmação de sua conta');
        return $user;

    }
}
