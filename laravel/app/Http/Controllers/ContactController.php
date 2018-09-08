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
        $data['from'] = $request->email;
        $data['name'] = $request->name;
        $data['message'] = $request->message;
        $data['sector'] = ($request->sector == 'sac' ? 'sac@popmartin.com.br' : '');

        if($data['sector']){
            Mail::send('emails.received_contact',['data' => $data], function ($message)use($data){
                $message->from($data['from'], $data['name'])
                    ->to($data['sector'], mb_strtoupper($data['sector']))
                    ->subject('Mensagem para o setor de ');
            });
            flash('Mensagem enviada com sucesso!', 'accept');
        }
        return redirect()->route('pages.contact');
    }
}