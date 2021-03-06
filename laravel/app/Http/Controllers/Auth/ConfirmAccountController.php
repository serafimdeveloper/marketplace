<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 29/03/2017
 * Time: 21:01
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\Account\UserRepository;
class ConfirmAccountController extends Controller
{
    public function confirm_page(){
        $user = Auth::user();
        return view('pages.confirm_account',compact('user'));
    }

    public function send_email(){
        $user = Auth::user();
        $data = ['email' => $user->email, 'user' => $user];
        send_mail('emails.confirmation_account',$data,'Confirmação de sua conta');
        flash('Email de confirmação de conta enviado com sucesso','accept');
        return redirect()->route('page.confirm_account');
    }

    public function confirm(UserRepository $repo, $email, $confirm){
        $user = $repo->getUser([],['email'=>$email, 'confirm_token' => $confirm]);
        $user->update(['active'=>1]);
        Auth::login($user);
        flash('Confirmação de conta efetuada com sucesso','accept');
        return redirect()->intended('account');
    }
}