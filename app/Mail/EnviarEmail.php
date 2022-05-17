<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Imagem;

class EnviarEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $imagem;
    public function __construct(Imagem $imagem)
    {
        $this->imagem = $imagem;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $endereco = '/imagens/' . $this->imagem->endereco;
        return $this
        ->subject('Envio de imagem do sistema Documento Digital')
        ->attach(url($endereco))
        ->from('marteloleite@gmail.com')
        ->view('admin.imagem.send_email');
    }
}
