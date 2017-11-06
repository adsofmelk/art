<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DSC_CitacionDescargosMail extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $datos;
    
    protected $consecutivo;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos, $consecutivo = '')
    {
        $this->datos = $datos;
        
        $this->consecutivo = $consecutivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
    	return $this->subject('Citación a descargos proceso '. $this->consecutivo)->view('emails.plantillagenerica',$this->datos);
    	
    }
}
