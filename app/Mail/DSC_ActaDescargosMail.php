<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DSC_ActaDescargosMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
    	$file = app('\App\Http\Controllers\disciplinarios\DSC_ActaDescargosController')->show('CYiJsZ0CgFamT0c7oldfwiPFw0PlJF7A5m2C');
    	
    	
    	return $this->from('adsofmelk-29048c@inbox.mailtrap.io')
    	->view('welcome')->attachData($file, 'archivo.pdf', [
    			'mime' => 'application/pdf',
    	]);
    }
}
