<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderContact extends Mailable {
    use Queueable, SerializesModels;

    /** @var  informações da mensagem */
    public $data;


    /**
     * Create a new message instance.
     */
    public function __construct($data){
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->from($this->data['from'])->view($this->data['view']);
    }
}
