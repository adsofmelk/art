<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DSC_ActaDescargosMail extends Mailable
{
    use Queueable, SerializesModels;
    
    protected $datos;
    protected $iddsc_proceso;
    protected $consecutivo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos,$iddsc_proceso, $consecutivo = '')
    {
        $this->datos = $datos;
        $this->iddsc_proceso = $iddsc_proceso;
        $this->consecutivo = $consecutivo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$file = app('\App\Http\Controllers\disciplinarios\DSC_ActaDescargosController')->show($this->iddsc_proceso);
    	
    	
    	return $this->subject('Acta descargos del Proceso '. $this->consecutivo)->view('emails.plantillagenerica',$this->datos)->attachData($file, 'acta_descargos.pdf', [
    			'mime' => 'application/pdf',
    	]);
    }
}
