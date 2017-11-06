<html>
<head>
<title>Actualización de estado proceso disciplinario
</title>
</head>
<body>
<p>Estimado {{$destinatario}}.</p> 
<p>El presente mensaje es para informarle que el proceso disciplinario <strong>{{$idproceso}}</strong> del señor(a) <strong>{{$responsable}}</strong> ha entrado al estado <strong>{{$estadoproceso}}</strong>.</p>
@if(sizeof($detalle) > 0)
<p><strong>Detalle de la evaluacióndel caso:</strong><br>{{$detalle}}</p>
@endif
<p>Para más información por favor ingrese a la plataforma de disciplinarios.</p>
<p>&nbsp;</p>

<p>
	<img src = '{{ config('app.url') }}/images/logoarticulacion.png'>
</p>

<p><i>Este mensaje y cualquier archivo adjunto son de uso exclusivo y confidencial.  Si usted no es el destinatario real del mismo y ha recibido este mensaje por error, por favor informarnos de inmediato y a menos que haya instrucción en contrario,  sírvase destruirlo junto con todos sus anexos. Cualquier retención, utilización, copia o distribución total o parcial no autorizada de este mensaje  se encuentra prohibida.</i></p>

<p><i>This message and any attached file are  of confidential and privileged use.  If you are not the intended stated addressee and you have received this message in error, please notify us immediately, and unless otherwise directed, kindly destroy all copies hereof.  Any retention, use, copy or distribution whether partial o total of this email or its contents without authorization is strictly prohibited.</i></p>

<p><i>Ce message et toute pièce jointe sont sont d’usage exclusif et confidentiel. Si vous n'êtes pas le destinataire du même ou si vous avez reçu ce message par erreur,  nous vous prions de nous en informer immédiatement et sauf indication contraire, veuillez le détruire avec toutes ses annexes. Toute conservation, utilisation, copie ou distribution de tout ou partie de ce message sans autorisation est  interdite</i></p>

</body>
</html>