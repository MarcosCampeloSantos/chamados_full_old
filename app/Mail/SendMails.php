<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMails extends Mailable
{
    use Queueable, SerializesModels;

    private $usuario;
    private $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $mensagem)
    {
        $this->usuario = $user;
        $this->msg = $mensagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(subject:'Teste Feito Com sucesso!!');
        $this->to(address: $this->usuario->email, name: $this->usuario->name);
        $data=[
            'usuario'=>$this->usuario,
            'mensagem'=>$this->msg
        ];
        return $this->view('mail.stylemail', $data);
    }
}
