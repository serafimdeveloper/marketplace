<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 10/03/2017
 * Time: 14:01
 */

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Account\UserRepository;
use Illuminate\Support\Facades\Auth;
use Socialite;

class AuthController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
        $user_social = Socialite::driver('facebook')->user();
        /*$name = explode(" ",$user_social->name);

        if(Auth::attempt(['email' => $user_social->email, 'password' => $user_social->id])){
            return redirect()->intended();
        }else if($user = $this->user->store(['name' => $name[0], 'last_name' => $name[1], 'email' => $user_social->email,
            'password' => bcrypt($user_social->id), 'confirm_token'=> str_random(20), 'remember_token'=>str_random(20),
            'active'=> 1])) {
            Auth::login($user);
            return redirect()->intended();
        }*/
    }

}