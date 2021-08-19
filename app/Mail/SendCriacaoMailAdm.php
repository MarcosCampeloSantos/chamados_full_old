<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendCriacaoMailAdm extends Mailable
{
    use Queueable, SerializesModels;

    private $usuario;
    private $msg;
    private $chamado;
    private $email;
    private $assunto;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, String $mensagem, $chamado, $email, $assunto)
    {
        $this->usuario = $user;
        $this->msg = $mensagem;
        $this->chamado = $chamado;
        $this->email = $email;
        $this->assunto = $assunto;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Teste Feito Com sucesso!!');
        $this->to($this->email, $this->usuario->name);
        $data=[
            'usuario'=>$this->usuario,
            'mensagem'=>$this->msg,
            'chamado' => $this->chamado,
            'assunto' => $this->assunto,
        ];
        return $this->view('mail.stylemail_2', $data);
    }
}
