<?php
/**
 * Created by PhpStorm.
 * User: DouglasSerafim
 * Date: 11/03/2017
 * Time: 14:48
 */

namespace App\Http\Controllers;

use App\Mail\OrderContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller {
    public function indexGet(){
        return view('pages.contact');
    }

    public function sendMail(Request $request){
        $data['view'] = '';
        $data['from'] = $request->email;
        $data['name'] = $request->name;
        $data['message'] = $request->setor;

        Mail::to()->send(new OrderContact($data));
        return redirect()->route('pages.contact');

        Mail::send('emails.received_request', ['data' => $dados], function($mail) use($dados) {
            $mail->to($dados['email'])->subject('Confirmação de sua conta');
        });
    }
}