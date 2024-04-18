<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CorreoRechazoEvidencia extends Mailable
{
    use Queueable, SerializesModels;

    public $nombreArchivo;
    public $odt;
    public $comentario;
    public $fechaFormateada;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nombreArchivo, $odt, $comentario,$fechaFormateada)
    {
        $this->nombreArchivo = $nombreArchivo;
        $this->odt = $odt;
        $this->comentario = $comentario;
        $this->fechaFormateada = $fechaFormateada;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.rechazo_evidencia');
    }
}
